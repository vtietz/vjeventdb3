<?php
namespace VJmedia\Vjeventdb3\Service;

use VJmedia\Vjeventdb3\Domain\Model\Date;
use \DateTime;

/**
 * 
 * Provides some methods to convert and to handle events for template output.
 * 
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *         
 * @author Vincent Tietz <vincent.tietz@vj-media.de>
 *
 */
class EventUtils {
	
	private function __construct() {
	}
	

	public static function dateCorrection(\DateTime $datetime, $timeCorrection) {
		if($correctionSettings) {
			$starttimeString = date('Y-m-d 00:00:00', strtotime($timeCorrection, $datetime->getTimestamp()));
			$datetime = new DateTime($starttimeString);
		}
		return $datetime;
	}
	
}

?>