<?php
/**
* This class implements the show membership period functionality
*/

class CRM_Membershipperiod_Form {
	/**
	 * Render Membership period view template
	 * @param  CRM_Member_Form_MembershipView &$form [
	 */
	public function showMembershipPeriod( &$form ) {
		// Check membership periods
		$id = CRM_Utils_Request::retrieve( 'id', 'Positive', $form );
		$result = CRM_Core_DAO::executeQuery( "SELECT * FROM civicrm_membershipperiod WHERE membership_id = {$id}" );
		// Exit if membership periods don't exist
		if( 1 > $result->N ) {
			return;
		}
		// Store membership periods for later
		$periods = array();
		while( $result->fetch() ){
			$periods[] = $result;
		}
		$form->assign( 'periods', $periods );
		// Define template path
		$template_path = dirname( dirname( __DIR__ ) ) . '/templates';
		// Enqueue custom template
		CRM_Core_Region::instance( 'page-body' )->add( array(
			'template'	=> "{$template_path}/CRM/Membershipperiod/Form/MembershipPeriodView.tpl"
		) );
	}

}