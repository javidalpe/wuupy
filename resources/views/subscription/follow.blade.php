@if($user->plan == 'one')
  Follow for 0,99€/month
@elseif($user->plan == 'five')
  Follow for 4,99€/month
@elseif($user->plan == 'ten')
  Follow for 9,99€/month
@elseif($user->plan == 'twenty')
  Follow for 19,99€/month
@endif
