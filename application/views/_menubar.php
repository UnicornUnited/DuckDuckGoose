<?php
?>

<ul class="nav navbar-nav navbar-right">
    {menudata}
        <li><a href="{link}">{name}</a></li>
    {/menudata}
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">User Role<b class="caret"></b></a>
      <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                  <li><a href="/roles/actor/Guest">Guest&nbsp;&nbsp;{login_checkmark_guest}</a></li>
                  <li><a href="/roles/actor/Admin">Admin&nbsp;&nbsp;{login_checkmark_admin}</a></li>
      </ul>
    </li>  
</ul>

