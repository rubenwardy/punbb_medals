<?php
// WHAT DOES THIS MEAN?
// [medal name] => [icon_name]
// An icon name of "foo" would made the medal icon be: img/medal_foo.png

  $medal_types = array(
  
        // How many mods have they made?
  	"first mod" => "bronze", // has made a mod
  	"many mods" => "silver", // has made over 5 mods
  	"mod factory" => "gold", // has made over 10 mods

        // How creative are their mods?
  	"mod pioneer" => "silver", // has made a mod considered innovative
  	"master mod pioneer" => "gold", //has made 7 or more mods considered innovative
  
        // How many servers do they have?
  	"first server" => "bronze", // owns a server
  	"server owner" => "gold", // owns 2 or more servers
  	"master server owner" => "gold", // owns 3 or more servers

        // How popular is their server?
  	"server owner" => "bronze", // owns an active server
  	"big server owner" => "silver", // owns a server with over a 500 replies
  	"mega server owner" => "gold", // owns a server with over a 1000 replies

        // Have they won a competition?
  	"competition winner" => "gold", // won a competition

        // How much do they contribute?
  	"contributer" => "gold", // someone who has contributed a lot to the development, whether that be c++, mods or other
  	"developer" => "silver", // someone who has done some c++ contribution
  	"master developer" => "gold", // someone who has done a lot of c++ contribution
  );
?>