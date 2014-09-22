<?php

namespace VJmedia\Vjeventdb3\Controller;

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
	 * action show
	 *
	 * @return void
	 */
	public function showAction() {
		$eventOrder = $this->objectManager->get('VJmedia\Vjeventdb3\Domain\Model\EventOrder');
		$eventOrder->setEvent($this->getCurrentEvent());
		$this->view->assign('eventOrder', $eventOrder);
		$this->view->assign('events', $this->eventRepository->findAll());
		$this->view->assign('sr_freecap', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('sr_freecap'));
		
		$cObjData = $this->configurationManager->getContentObject()->data;
		$this->view->assign('data', $cObjData);
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
		if($this->getSetting('mail_recipient')) {
			$subject = sprintf($this->getSetting('mail_subject', '%s'), $eventOrder->getEvent()->getTitle());
			$this->sendMail($this->getSetting('mail_recipient'), $subject , $message, $eventOrder->getEmail());
		}
	}
	
	protected function sendMailToSender(\VJmedia\Vjeventdb3\Domain\Model\EventOrder $eventOrder) {
		$message = $this->getMessage($eventOrder, 'NotifySender');
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
		return mail($recipient, $subject,  $message, $additionalHeader);
	}
	
}

