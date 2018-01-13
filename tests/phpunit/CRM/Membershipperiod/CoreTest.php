<?php

use CRM_Membershipperiod_ExtensionUtil as E;
use Civi\Test\HeadlessInterface;

/**
 * Test the core functionality
 *
 * @group headless
 * @group legacy
 */
class CRM_MembershipPeriod_CoreTest extends \CiviUnitTestCase implements HeadlessInterface {

  private $membership_type;

  private $contact;

  public function setUpHeadless() {
  }

  public function setUp() {
    parent::setUp();
    $this->quickCleanup( array( 'civicrm_membershipperiod' ) );
    $this->setUpTestData();
  }

  public function tearDown() {
    parent::tearDown();
  }

  public function testInsertMembershipPeriod () {
    // Assert that table is empty
    $this->assertDBQuery( 0, 'SELECT count(*) FROM civicrm_membershipperiod' );
    // Assert that membership type exists
    $this->assertDBQuery( 1, "SELECT count(*) FROM civicrm_membership_type WHERE id = {$this->membership_type['id']}" );
    // Assert that contact exists
    $this->assertDBQuery( 1, "SELECT count(*) FROM civicrm_contact WHERE id = {$this->contact['id']}" );

    // Create new membership 
    $result = civicrm_api3( 'Membership', 'create', array(
      'membership_type_id'  => $this->membership_type['id'],
      'contact_id'          => $this->contact['id'],
      'status_id'           => 1,
    ) );

    // Assert that corresponding membership record is inserted
    $this->assertDBQuery( 1, 'SELECT count(*) FROM civicrm_membershipperiod' );
    $this->assertDBQuery( 1, "SELECT count(*) FROM civicrm_membershipperiod WHERE membership_id = {$result['id']}" );

  }

  public function setUpTestData() {
    // Create test DB entries
    $this->contact = civicrm_api3( 'Contact', 'create', array(
      'first_name'    => 'John',
      'last_name'     => 'Doe',
      'contact_type'  => 'Individual'
    ) );
    $organization = civicrm_api3( 'Contact', 'create', array(
      'organization_name' => 'test organization',
      'contact_type'      => 'Organization'
    ) );
    $domain = civicrm_api3( 'Domain', 'create', array(
      'name'            => 'test domain',
      'domain_version'  => 'test version'
    ) );
    $financial_type = civicrm_api3( 'FinancialType', 'create', array(
     'name'       => 'test financial type',
     'is_active'  => 1
    ) );
    $this->membership_type = civicrm_api3( 'MembershipType', 'create', array(
      'name'                  => 'test membership type',
      'domain_id'             => $domain['id'],
      'financial_type_id'     => $financial_type['id'],
      'member_of_contact_id'  => $organization['id'],
      'duration_unit'         => 'month',
      'duration_interval'     => 12,
      'period_type'           => 'rolling',
    ) );
  }
}
