<?php

namespace VJmedia\Vjeventdb3\Controller;

use \VJmedia\Vjeventdb3\ViewHelper\DateItemViewHelper;
use \VJmedia\Vjeventdb3\ViewModel\SelectOption;
use \VJmedia\Vjeventdb3\Service\DateUtils;
use \DateTime;

/***************************************************************
 *
*  Copyright notice
*
*  (c) 2014 Vincent Tietz <vincent.tietz@vj-media.de>, vjmedia
*
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 3 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * EventOrderFormController
 */
class EventOrderFormController extends \VJmedia\Vjeventdb3\Controller\AbstractController {

	/**
	 * eventRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\EventRepository
	 * @inject
	 */
	protected $eventRepository = NULL;

	/**
	 * eventOrderRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\EventOrderRepository
	 * @inject
	 */
	protected $eventOrderRepository = NULL;
	
	/**
	 * dateRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\DateRepository
	 * @inject
	 */
	protected $dateRepository = NULL;

	/**
	 * exceptionalDateRepository
	 *
	 * @var \VJmedia\Vjeventdb3\Domain\Repository\ExceptionalDateRepository
	 * @inject
	 */
	protected $exceptionalDateRepository = NULL;
	
	/**
	 * Current DateItemViewHelper.
	 *
	 * @var \VJmedia\Vjeventdb3\ViewHelper\DateItemViewHelper
	 * @inject
	 */
	protected $dateItemViewHelper = NULL;
	
	/**
	 * Current TranslateDateViewHelper.
	 *
	 * @var \VJmedia\Vjeventdb3\ViewHelper\TranslateDateViewHelper
	 * @inject
	 */
	protected $translateDateViewHelper = NULL;
	
	/**
	 * Current TimestampViewHelper.
	 *
	 * @var \VJmedia\Vjeventdb3\ViewHelper\TimestampViewHelper
	 * @inject
	 */
	protected $timestampViewHelper = NULL;
	
	/**
	 * dateService
	 *
	 * @var \VJmedia\Vjeventdb3\Service\DateService
	 * @inject
	 */
	protected $dateService = NULL;	
	
	/**
	 * action show
	 *
	 * @return void
	 */
	public function showAction() {
		
		$eventOrder = $this->objectManager->get('VJmedia\Vjeventdb3\Domain\Model\EventOrder');
		$this->view->assign('eventOrder', $eventOrder);

		$events = $this->eventRepository->findAll();
		$this->addTitleWithAgeCategory($events);

		$this->view->assign('events', $events);
		$this->view->assign('sr_freecap', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('sr_freecap'));
		
		$eventsData = $this->getEventsData($events, $this->settings['eventOrderForm']['appointmentSelector']['maxItemsPerDate']);
		$this->view->assign('eventsDataJSON', json_encode($eventsData));
		$this->view->assign('eventsData', $eventsData);
		$this->view->assign('data', $this->configurationManager->getContentObject()->data);
		$this->view->assign('settings', $this->settings);
		$this->view->assign('selectedTime', $this->getCurrentTime());
		$this->view->assign('submissionFormMode', $this->getSubmissionFormMode());
		
		
		$event = $this->getCurrentEvent();
		if(!empty($event)) {
			$eventOrder->setEvent($event);
			$this->view->assign('dateItems', $this->getDateItemOptions($event->getDates()));
			$this->view->assign('eventData', $eventsData[$event->getUid()]);
			$this->view->assign('submissionFormMode', $this->getSubmissionFormMode($event));
			$this->view->assign('appointments', $eventsData[$event->getUid()]['appointments']);
		}
		
		$date = $this->getCurrentDate();
		if(empty($date)) {
			$date = $this->objectManager->get('VJmedia\Vjeventdb3\Domain\Model\Date');
			
		}
		else if(!empty($event)) {
			$filteredAppointments = array();
			foreach($eventsData[$event->getUid()]['appointments'] as $appointment) {
				if($appointment['dateUid'] == $date->getUid()) {
					$filteredAppointments[] = $appointment;
				}
			}
			$this->view->assign('appointments', $filteredAppointments);
		}
		
		$eventOrder->setDate($date);
		
		
	}
	
	private function getEventsData($events, $maxAppointmentsPerDate) {
		
		$result = array();
		foreach($events as $event) {
			$item = array();
			
			$item['title'] = $event->getTitle();
			
			$item['ageCategory'] = array();
			foreach($event->getAgeCategory() as $ageCategory) {
				if(!$ageCategory->isHidden()) {
					$item['ageCategory'][$ageCategory->getUid()] = $ageCategory->getName();
				}
			}
			
			$item['dates'] = array();
			foreach($event->getDates() as $date) {
				if(!$date->isHidden() && $date->getStartDate()) {
					$item['dates'][$date->getUid()] = $this->getDateLabel($date);
				}
			}
			
			
			$item['appointments'] = array();
			$appointments = $this->dateService->getAllDates($event->getDates(), new DateTime(), NULL, $maxAppointmentsPerDate);
			
			$appointments = $this->getFilteredAppointmentsByExceptionalDates($appointments, $event->getExceptionalDates());
				
			foreach($appointments as $appointment) {
				if(!$appointment->isHidden() && $appointment->getStartDate()) {
					$appointmentLabel = $this->translateDateViewHelper->translate(
							date($this->settings['eventOrderForm']['appointmentSelector']['dateTimeFormat'], $appointment->getStartTimestamp())
					);
					$appointmentValue = date('d-m-Y H:i', $appointment->getStartTimestamp());
					$item['appointments'][$appointmentValue]['label'] = $appointmentLabel;
					$item['appointments'][$appointmentValue]['value'] = $appointmentValue;
					$item['appointments'][$appointmentValue]['dateUid'] = $appointment->getUid();
					$item['appointments'][$appointmentValue]['eventUid'] = $event->getUid();
					$item['appointments'][$appointmentValue]['startTimestamp'] = $appointment->getStartTimestamp();
				}
			}
				
			$result[$event->getUid()] = $item;
		}

		return $result;
		
	}
	
	private function getFilteredAppointmentsByExceptionalDates($appointments, $exceptionalDates) {
		
		if(!$exceptionalDates) {
			return $appointments;
		}
				
		$this->dateService->addExceptionalDates($appointments, $exceptionalDates);
		
		$theAppointments = array();
		foreach ($appointments as $appointment) {
			if(!$appointment->getExceptionalDate()) {
				$theAppointments[] = $appointment;
			}
		}
		
		return $theAppointments;
		
	}
	
	/**
	 * 
	 * @param \VJmedia\Vjeventdb3\Domain\Model\Event $event
	 * @return The submission mode.
	 */
	private function getSubmissionFormMode($event = NULL) {
		
		$submissionMode = array('date' => false, 'time' => false);
		
		$definedSubmissionMode = 0;
		if(!$event || $event->getSubmissionFormMode() == 0) {
			$definedSubmissionMode = $this->settings['eventOrderForm']['defaultSubmissionMode'];
		}
		else {
			$definedSubmissionMode = $event->getSubmissionFormMode(); 
		}
		
		if(!$definedSubmissionMode) {
			return array();
		}
		
		if($definedSubmissionMode == 1) {
			$submissionMode['date'] = true;
			$submissionMode['time'] = false;
		}
		else if($definedSubmissionMode == 2) {
			$submissionMode['date'] = false;
			$submissionMode['time'] = true;
		}
		else if($definedSubmissionMode == 3) {
			$submissionMode['date'] = true;
			$submissionMode['time'] = true;
		}
		
		return $submissionMode;
		
	}
	
	private function getDateItemOptions(&$dates) {
		$options = array();
		foreach ($dates as $date) {
			if(!$date->isHidden() && $date->getStartDate()) {
				$label = $this->getDateLabel($date);
				$option = new \VJmedia\Vjeventdb3\Domain\ViewModel\SelectOption($date->getUid(), $label);
				$options[] = $option;
			}
		}
		return $options;
	}
	
	private function getDateLabel(&$date) {
		return $this->dateItemViewHelper->render($date,
				$this->settings['eventOrderForm']['showStartDay'],
				$this->settings['eventOrderForm']['timeFormat'],
				$this->settings['adjustFrontendTime']);
	}
	
	private function addTitleWithAgeCategory(&$events) {
		foreach($events as $event) {
			$event->setTitleWithAgeCategory($event->getTitle().' '.$this->getAgeCategoryList($event));
		}
	}
	
	private function getAgeCategoryList(&$event) {
		$categories = $event->getAgeCategory()->toArray();
		$categoryNames = array();
		foreach($categories as $category) {
			$categoryNames[] = $category->getName();
		}
		return $this->joinWithLastSeparator($categoryNames, ' &amp; ');
	}
	
	private function joinWithLastSeparator(array $array, $separator = ' & ') {
		$last  = array_slice($array, -1);
		$first = join(', ', array_slice($array, 0, -1));
		$both  = array_filter(array_merge(array($first), $last));
		return join(' & ', $both);
	}
	
	/**
	 * @param \VJmedia\Vjeventdb3\Domain\Model\EventOrder $eventOrder
	 */
	protected function notify(\VJmedia\Vjeventdb3\Domain\Model\EventOrder $eventOrder) {
		$message = $this->getMessage($eventOrder);
		$this->sendMail($this->getSetting('mail_recipient'), $this->getSetting('mail_subject'), $message, $eventOrder->getEmail());
	}
	
	/**
	 * @param \VJmedia\Vjeventdb3\Domain\Model\EventOrder $eventOrder
	 * @param string $templateName
	 * @return string
	 */
	protected function getMessage(\VJmedia\Vjeventdb3\Domain\Model\EventOrder $eventOrder, $templateName) {
		$renderer = $this->getPlainTextRenderer($templateName, $this->getSetting('eventOrderForm.templateFile.'.$templateName));
		$renderer->assign('eventOrder', $eventOrder);
		$renderer->assign('url', $this->uriBuilder->getRequest()->getBaseUri());
		return $renderer->render();
	}
	
	protected function getCurrentEvent() {
		$eventUid = $_GET['tx_vjeventdb3_eventdetail']['event'];
		$event = $this->eventRepository->findByUid($eventUid);
		return $event;
	}
	
	protected function getCurrentDate() {
		$dateUid = $_GET['tx_vjeventdb3_eventdetail']['date'];
		$date = $this->dateRepository->findByUid($dateUid);
		return $date;
	}	
	
	protected function getCurrentTime() {
		return $_GET['tx_vjeventdb3_eventdetail']['time'];
	}
	
	/**
	 * @return void
	 */
	protected function initializeSubmitAction(){

		$propertyMappingConfiguration = $this->arguments['eventOrder']->getPropertyMappingConfiguration();
		$propertyMappingConfiguration->allowProperties('appointment');
		
		if (isset($this->arguments['eventOrder'])) {
			$this->arguments['eventOrder']
			->getPropertyMappingConfiguration()
			->forProperty('appointment')
			->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\DateTimeConverter',
					\TYPO3\CMS\Extbase\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT,'d-m-Y H:i');
		}
		
	}
	
	/**
	 * action submit
	 * @param \VJmedia\Vjeventdb3\Domain\Model\EventOrder $eventOrder
	 * @return void
	 */
	public function submitAction(\VJmedia\Vjeventdb3\Domain\Model\EventOrder $eventOrder) {
		$this->eventOrderRepository->add($eventOrder);
		$this->view->assign('eventOrder', $eventOrder);
		$this->sendMailToRecipient($eventOrder);
		if($this->getSetting('mail_send_copy_to_sender')) {
			$this->sendMailToSender($eventOrder);
		}
		
	}
	
	protected function sendMailToRecipient(\VJmedia\Vjeventdb3\Domain\Model\EventOrder $eventOrder) {
		$message = $this->getMessage($eventOrder, 'NotifyRecipient');
		$eventOrder->setMailtorecipient($message);
		if($this->getSetting('mail_recipient')) {
			$subject = sprintf($this->getSetting('mail_subject', '%s'), $eventOrder->getEvent()->getTitle());
			$this->sendMail($this->getSetting('mail_recipient'), $subject , $message, $eventOrder->getEmail());
		}
	}
	
	protected function sendMailToSender(\VJmedia\Vjeventdb3\Domain\Model\EventOrder $eventOrder) {
		$message = $this->getMessage($eventOrder, 'NotifySender');
		$eventOrder->setMailtosender($message);
		if($this->getSetting('mail_recipient')) {
			$subject = sprintf($this->getSetting('mail_subject', '%s'), $eventOrder->getEvent()->getTitle());
			$this->sendMail($eventOrder->getEmail(), $subject , $message, $this->getSetting('mail_recipient'));
		}
	}
	
	/**
	 * @param string $recipient
	 * @param string $subject
	 * @param string $message
	 * @param string $sender
	 */
	protected function sendMail($recipient, $subject, $message, $sender) {
		// TODO use \TYPO3\CMS\Core\Mail\MailMessage(), but currently error 500
		$additionalHeader = 'From: '.$sender. "\r\n";
		$additionalHeader .= 'Content-type: text/plain; charset=utf-8' . "\r\n";
		$this->log("Sending email to ". $recipient, 1);
		return mail($recipient, $subject,  $message, $additionalHeader);
	}
	
}

