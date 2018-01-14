{* Render Membership period view in Membership view *}
<div class="crm-accordion-wrapper">
	<div class="crm-accordion-header">{ts}Membership Periods{/ts}</div>
	<div class="crm-accordion-body">
		<ul>
			{foreach from=$periods item=period name=periods}
			<li> {ts}Term/Period{/ts} {$smarty.foreach.periods.iteration}: {$period->start_date|date_format:"%e %b %Y"} - {$period->end_date|date_format:"%e %b %Y"}
			{if $period->contribution_id} 
            <a target="_blank" href="{crmURL p='civicrm/contact/view/contribution' q="reset=1&id=`$period->contribution_id`&cid=`$period->contact_id`&action=view&context=dashboard"}">{ts}View Contribution{/ts}</a>		
            {/if}
        </li>
			{/foreach}
		</ul>
	</div>
</div>