<?php
/**
* This class implements the show membership period functionality
*/

class CRM_Membershipperiod_Form {

	public function showMembershipPeriod( &$form ) {
		$id = CRM_Utils_Request::retrieve( 'id', 'Positive', $form );
		$periods = CRM_Core_DAO::executeQuery( "SELECT * FROM civicrm_membershipperiod WHERE membership_id = {$id}" );

		$form->addClass( 'membership-period' );

		// Define template path
		$template_path = dirname( dirname( __DIR__ ) ) . '/templates';

		// Enqueue custom template
		CRM_Core_Region::instance( 'page-body' )->add( array(
			'template'	=> "{$template_path}/CRM/Membershipperiod/Form/MembershipPeriodView.tpl"
		) );
	}

}