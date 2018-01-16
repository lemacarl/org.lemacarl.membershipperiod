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

  /**
  * Do basic test to ensure it runs with no errors
  **/
  public function testShowMembershipPeriod() {
    // Mock our dependencies
    $form = Mockery::mock( 'CRM_Member_Form_MembershipView' )->shouldIgnoreMissing();
    $form->shouldReceive( 'get' )->once()->andReturn( 1 );

    // Simulate hook by calling method directly 
    $membership_form = new CRM_Membershipperiod_Form();
    $membership_form->showMembershipPeriod( $form );

    $this->assertTrue( is_object( $form ) );
  }
}
