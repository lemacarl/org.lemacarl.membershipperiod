<?php
/**
* This class contains the core code that implements the new functionality
*
**/

class CRM_Membershipperiod_Core {

	/**
	 * Handle new membership record hook
	 * @param  string $op     Operation type i.e. create or edit
	 * @param  CRM_Member_BAO_Membership $object 
	 */
	public function insertMembershipPeriod( $op, $object ) {
		if( 'create' == $op ) {
			$this->createNewMembershipPeriod( $object );
		}
		elseif( 'edit' == $op ) {
			$membership_id = $object->id;
			$result = CRM_Core_DAO::executeQuery( "SELECT * FROM civicrm_membershipperiod WHERE membership_id = $membership_id" );
			if( $result->fetch() ) {
				$this->editMembershipPeriod( $object );
			}
			else {
				$this->createNewMembershipPeriod( $object );
			}
			$result->free();
		}
	}

	/**
	 * Create new membership period record
	 * @param  CRM_Member_BAO_Membership $object 
	 */
	private function createNewMembershipPeriod( $object ) {
		$contribution_id = $this->getContributionID( $object );
		if( $contribution_id ){
			$params = array(
				1 => array( $object->id, 'Integer' ),
				2 => array( $object->contact_id, 'Integer' ),		
				3 => array( $object->start_date, 'Date' ),
				4 => array( $object->end_date, 'Date' ),
				5 => array( $contribution_id, 'Integer' )
			);
			$result = CRM_Core_DAO::executeQuery( 'INSERT INTO civicrm_membershipperiod ( membership_id, contact_id, start_date, end_date, contribution_id ) VALUES ( %1, %2, %3, %4, %5 )', $params );
			$result->free();
		}
		else{
			$params = array(
				1 => array( $object->id, 'Integer' ),
				2 => array( $object->contact_id, 'Integer' ),		
				3 => array( $object->start_date, 'Date' ),
				4 => array( $object->end_date, 'Date' ),		
			);
			$result = CRM_Core_DAO::executeQuery( 'INSERT INTO civicrm_membershipperiod ( membership_id, contact_id, start_date, end_date ) VALUES ( %1, %2, %3, %4 )', $params );
			$result->free();
		}
	}

	/**
	 * Update membership period record 
	 * @param  CRM_Member_BAO_Membership $object 
	 */
	private function editMembershipPeriod( $object ) {
		$contribution_id = $this->getContributionID( $object );
		if( $contribution_id ) {
			$params = array(
				1 => array( $object->start_date, 'Date' ),
				2 => array( $object->end_date, 'Date' ),
				3 => array( $contribution_id, 'Integer' ),
				4 => array( $object->id, 'Integer' )
			);

			$result = CRM_Core_DAO::executeQuery( 'UPDATE civicrm_membershipperiod SET start_date = %1, end_date = %2, contribution_id = %3 WHERE membership_id = %4', $params );
			$result->free();
		}
		else {
			$params = array(
				1 => array( $object->start_date, 'Date' ),
				2 => array( $object->end_date, 'Date' ),
				3 => array( $object->id, 'Integer' )
			);

			$result = CRM_Core_DAO::executeQuery( 'UPDATE civicrm_membershipperiod SET start_date = %1, end_date = %2 WHERE membership_id = %3', $params );
			$result->free();
		}
	}

	/**
	 * Get the most recent contribution ID
	 * @param  CRM_Member_BAO_Membership $object 
	 * @return int|bool
	 */
	private function getContributionID( $object ) {
		$result = CRM_Core_DAO::executeQuery( "SELECT id FROM civicrm_contribution WHERE contact_id = {$object->contact_id} AND financial_type_id = 2" );
		if( $result->N > 0 ){
			// Return the most recent 
			$result->fetch();
			return $result->id;
		}
		return false;
	}
}