@if($status == 'active')
    <span class="ui green label">Following you</span>
@elseif($status == 'pending_active')
    <span class="ui orange label" data-tooltip="It could take a few minutes">Processing approval</span>
@elseif($status == 'inactive')
    <span class="ui label">Not following you</span>
@elseif($status == 'pending_inactive')
    <span class="ui orange label">Processing unfollow</span>
@endif
