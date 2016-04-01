<!-- START SIDEBAR MENU-->
<div class="col-sm-3 col-md-2 sidebar">
    <ul class="nav nav-sidebar">
        <li id="navEdtFcl"><a href="{{url('/facilities/edit/'.$facility->id)}}">Edit</a></li>
        <li id="navFclOfr"><a href="{{url('/facility/offer/'.$facility->id)}}">Offers</a></li>
        <li id="navFclMem"><a href="{{url('/facility/team/'.$facility->id)}}">Team</a></li>
        <li id="navFclOvw"><a href="{{url('/facility/profile/'.$facility->id)}}">Profile</a></li>
    </ul>
</div>
<!-- END SIDEBAR MENU -->