<?php

use CRM_Membershipperiod_ExtensionUtil as E;
use Civi\Test\HeadlessInterface;

/**
 * Test the form functionality
 *
 * @group headless
 * @group legacy
 */
class CRM_MembershipPeriod_FormTest extends \CiviUnitTestCase implements HeadlessInterface {

  public function setUpHeadless() {
  }

  public function setUp() {
    parent::setUp();
  }

  public function tearDown() {
    parent::tearDown();
  }

  public function testShowMembershipPeriod() {
    // Mock our dependencies
    $form = new CRM_Core_Form();

    // Simulate hook by calling method directly 
    $membership_form = new CRM_Membershipperiod_Form();
    $membership_form->showMembershipPeriod( $form );

    $this->assertTrue( true );
  }
}
