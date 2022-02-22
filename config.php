<?php
date_default_timezone_set("Asia/Kolkata");
$base_url = "https://prismblr.com/kot";
$mysql_hostname = "localhost";
$mysql_user = "prism";
$mysql_password = "1bit_mysql";
#$mysql_user = "root";
#$mysql_password = "";
$mysql_database = "prismdev";
$conn = new mysqli($mysql_hostname, $mysql_user, $mysql_password, $mysql_database);
$displayCurrency = 'INR';

function decrypt_password($Prm_pwd){
  $Decode = array();
  $Decode[0]["orgnlasc"][0] = ord("A"); $Decode[0]["decodasc"][0] = ord("5");
  $Decode[0]["orgnlasc"][1] = ord("B"); $Decode[0]["decodasc"][1] = ord("O");
  $Decode[0]["orgnlasc"][2] = ord("C"); $Decode[0]["decodasc"][2] = ord("P");
  $Decode[0]["orgnlasc"][3] = ord("D"); $Decode[0]["decodasc"][3] = ord("E");
  $Decode[0]["orgnlasc"][4] = ord("E"); $Decode[0]["decodasc"][4] = ord("L");
  $Decode[0]["orgnlasc"][5] = ord("F"); $Decode[0]["decodasc"][5] = ord("0");
  $Decode[0]["orgnlasc"][6] = ord("G"); $Decode[0]["decodasc"][6] = ord("2");
  $Decode[0]["orgnlasc"][7] = ord("H"); $Decode[0]["decodasc"][7] = ord("Z");
  $Decode[0]["orgnlasc"][8] = ord("I"); $Decode[0]["decodasc"][8] = ord("A");
  $Decode[0]["orgnlasc"][9] = ord("J"); $Decode[0]["decodasc"][9] = ord("6");
  $Decode[0]["orgnlasc"][10] = ord("K"); $Decode[0]["decodasc"][10] = ord("N");
  $Decode[0]["orgnlasc"][11] = ord("L"); $Decode[0]["decodasc"][11] = ord("F");
  $Decode[0]["orgnlasc"][12] = ord("M"); $Decode[0]["decodasc"][12] = ord("3");
  $Decode[0]["orgnlasc"][13] = ord("N"); $Decode[0]["decodasc"][13] = ord("T");
  $Decode[0]["orgnlasc"][14] = ord("O"); $Decode[0]["decodasc"][14] = ord("G");
  $Decode[0]["orgnlasc"][15] = ord("P"); $Decode[0]["decodasc"][15] = ord("7");
  $Decode[0]["orgnlasc"][16] = ord("Q"); $Decode[0]["decodasc"][16] = ord("V");
  $Decode[0]["orgnlasc"][17] = ord("R"); $Decode[0]["decodasc"][17] = ord("H");
  $Decode[0]["orgnlasc"][18] = ord("S"); $Decode[0]["decodasc"][18] = ord("4");
  $Decode[0]["orgnlasc"][19] = ord("T"); $Decode[0]["decodasc"][19] = ord("8");
  $Decode[0]["orgnlasc"][20] = ord("U"); $Decode[0]["decodasc"][20] = ord("Y");
  $Decode[0]["orgnlasc"][21] = ord("V"); $Decode[0]["decodasc"][21] = ord("1");
  $Decode[0]["orgnlasc"][22] = ord("W"); $Decode[0]["decodasc"][22] = ord("D");
  $Decode[0]["orgnlasc"][23] = ord("X"); $Decode[0]["decodasc"][23] = ord("Q");
  $Decode[0]["orgnlasc"][24] = ord("Y"); $Decode[0]["decodasc"][24] = ord("S");
  $Decode[0]["orgnlasc"][25] = ord("Z"); $Decode[0]["decodasc"][25] = ord("9");

  $Decode[0]["orgnlasc"][26] = ord("0"); $Decode[0]["decodasc"][26] = ord("C");
  $Decode[0]["orgnlasc"][27] = ord("1"); $Decode[0]["decodasc"][27] = ord("I");
  $Decode[0]["orgnlasc"][28] = ord("2"); $Decode[0]["decodasc"][28] = ord("W");
  $Decode[0]["orgnlasc"][29] = ord("3"); $Decode[0]["decodasc"][29] = ord("M");
  $Decode[0]["orgnlasc"][30] = ord("4"); $Decode[0]["decodasc"][30] = ord("B");
  $Decode[0]["orgnlasc"][31] = ord("5"); $Decode[0]["decodasc"][31] = ord("R");
  $Decode[0]["orgnlasc"][32] = ord("6"); $Decode[0]["decodasc"][32] = ord("K");
  $Decode[0]["orgnlasc"][33] = ord("7"); $Decode[0]["decodasc"][33] = ord("U");
  $Decode[0]["orgnlasc"][34] = ord("8"); $Decode[0]["decodasc"][34] = ord("X");
  $Decode[0]["orgnlasc"][35] = ord("9"); $Decode[0]["decodasc"][35] = ord("J");

  $Decode[1]["orgnlasc"][0] = ord("A"); $Decode[1]["decodasc"][0] = ord("7");
  $Decode[1]["orgnlasc"][1] = ord("B"); $Decode[1]["decodasc"][1] = ord("0");
  $Decode[1]["orgnlasc"][2] = ord("C"); $Decode[1]["decodasc"][2] = ord("9");
  $Decode[1]["orgnlasc"][3] = ord("D"); $Decode[1]["decodasc"][3] = ord("D");
  $Decode[1]["orgnlasc"][4] = ord("E"); $Decode[1]["decodasc"][4] = ord("X");
  $Decode[1]["orgnlasc"][5] = ord("F"); $Decode[1]["decodasc"][5] = ord("3");
  $Decode[1]["orgnlasc"][6] = ord("G"); $Decode[1]["decodasc"][6] = ord("E");
  $Decode[1]["orgnlasc"][7] = ord("H"); $Decode[1]["decodasc"][7] = ord("8");
  $Decode[1]["orgnlasc"][8] = ord("I"); $Decode[1]["decodasc"][8] = ord("M");
  $Decode[1]["orgnlasc"][9] = ord("J"); $Decode[1]["decodasc"][9] = ord("5");
  $Decode[1]["orgnlasc"][10] = ord("K"); $Decode[1]["decodasc"][10] = ord("Y");
  $Decode[1]["orgnlasc"][11] = ord("L"); $Decode[1]["decodasc"][11] = ord("W");
  $Decode[1]["orgnlasc"][12] = ord("M"); $Decode[1]["decodasc"][12] = ord("1");
  $Decode[1]["orgnlasc"][13] = ord("N"); $Decode[1]["decodasc"][13] = ord("K");
  $Decode[1]["orgnlasc"][14] = ord("O"); $Decode[1]["decodasc"][14] = ord("6");
  $Decode[1]["orgnlasc"][15] = ord("P"); $Decode[1]["decodasc"][15] = ord("C");
  $Decode[1]["orgnlasc"][16] = ord("Q"); $Decode[1]["decodasc"][16] = ord("Z");
  $Decode[1]["orgnlasc"][17] = ord("R"); $Decode[1]["decodasc"][17] = ord("U");
  $Decode[1]["orgnlasc"][18] = ord("S"); $Decode[1]["decodasc"][18] = ord("H");
  $Decode[1]["orgnlasc"][19] = ord("T"); $Decode[1]["decodasc"][19] = ord("2");
  $Decode[1]["orgnlasc"][20] = ord("U"); $Decode[1]["decodasc"][20] = ord("4");
  $Decode[1]["orgnlasc"][21] = ord("V"); $Decode[1]["decodasc"][21] = ord("G");
  $Decode[1]["orgnlasc"][22] = ord("W"); $Decode[1]["decodasc"][22] = ord("N");
  $Decode[1]["orgnlasc"][23] = ord("X"); $Decode[1]["decodasc"][23] = ord("T");
  $Decode[1]["orgnlasc"][24] = ord("Y"); $Decode[1]["decodasc"][24] = ord("F");
  $Decode[1]["orgnlasc"][25] = ord("Z"); $Decode[1]["decodasc"][25] = ord("I");

  $Decode[1]["orgnlasc"][26] = ord("0"); $Decode[1]["decodasc"][26] = ord("R");
  $Decode[1]["orgnlasc"][27] = ord("1"); $Decode[1]["decodasc"][27] = ord("J");
  $Decode[1]["orgnlasc"][28] = ord("2"); $Decode[1]["decodasc"][28] = ord("Q");
  $Decode[1]["orgnlasc"][29] = ord("3"); $Decode[1]["decodasc"][29] = ord("V");
  $Decode[1]["orgnlasc"][30] = ord("4"); $Decode[1]["decodasc"][30] = ord("S");
  $Decode[1]["orgnlasc"][31] = ord("5"); $Decode[1]["decodasc"][31] = ord("O");
  $Decode[1]["orgnlasc"][32] = ord("6"); $Decode[1]["decodasc"][32] = ord("L");
  $Decode[1]["orgnlasc"][33] = ord("7"); $Decode[1]["decodasc"][33] = ord("P");
  $Decode[1]["orgnlasc"][34] = ord("8"); $Decode[1]["decodasc"][34] = ord("B");
  $Decode[1]["orgnlasc"][35] = ord("9"); $Decode[1]["decodasc"][35] = ord("A");

  $Decode[2]["orgnlasc"][0] = ord("A"); $Decode[2]["decodasc"][0] = ord("Y");
  $Decode[2]["orgnlasc"][1] = ord("B"); $Decode[2]["decodasc"][1] = ord("R");
  $Decode[2]["orgnlasc"][2] = ord("C"); $Decode[2]["decodasc"][2] = ord("I");
  $Decode[2]["orgnlasc"][3] = ord("D"); $Decode[2]["decodasc"][3] = ord("3");
  $Decode[2]["orgnlasc"][4] = ord("E"); $Decode[2]["decodasc"][4] = ord("7");
  $Decode[2]["orgnlasc"][5] = ord("F"); $Decode[2]["decodasc"][5] = ord("9");
  $Decode[2]["orgnlasc"][6] = ord("G"); $Decode[2]["decodasc"][6] = ord("2");
  $Decode[2]["orgnlasc"][7] = ord("H"); $Decode[2]["decodasc"][7] = ord("4");
  $Decode[2]["orgnlasc"][8] = ord("I"); $Decode[2]["decodasc"][8] = ord("6");
  $Decode[2]["orgnlasc"][9] = ord("J"); $Decode[2]["decodasc"][9] = ord("S");
  $Decode[2]["orgnlasc"][10] = ord("K"); $Decode[2]["decodasc"][10] = ord("D");
  $Decode[2]["orgnlasc"][11] = ord("L"); $Decode[2]["decodasc"][11] = ord("O");
  $Decode[2]["orgnlasc"][12] = ord("M"); $Decode[2]["decodasc"][12] = ord("L");
  $Decode[2]["orgnlasc"][13] = ord("N"); $Decode[2]["decodasc"][13] = ord("X");
  $Decode[2]["orgnlasc"][14] = ord("O"); $Decode[2]["decodasc"][14] = ord("N");
  $Decode[2]["orgnlasc"][15] = ord("P"); $Decode[2]["decodasc"][15] = ord("F");
  $Decode[2]["orgnlasc"][16] = ord("Q"); $Decode[2]["decodasc"][16] = ord("P");
  $Decode[2]["orgnlasc"][17] = ord("R"); $Decode[2]["decodasc"][17] = ord("U");
  $Decode[2]["orgnlasc"][18] = ord("S"); $Decode[2]["decodasc"][18] = ord("8");
  $Decode[2]["orgnlasc"][19] = ord("T"); $Decode[2]["decodasc"][19] = ord("1");
  $Decode[2]["orgnlasc"][20] = ord("U"); $Decode[2]["decodasc"][20] = ord("B");
  $Decode[2]["orgnlasc"][21] = ord("V"); $Decode[2]["decodasc"][21] = ord("K");
  $Decode[2]["orgnlasc"][22] = ord("W"); $Decode[2]["decodasc"][22] = ord("0");
  $Decode[2]["orgnlasc"][23] = ord("X"); $Decode[2]["decodasc"][23] = ord("5");
  $Decode[2]["orgnlasc"][24] = ord("Y"); $Decode[2]["decodasc"][24] = ord("A");
  $Decode[2]["orgnlasc"][25] = ord("Z"); $Decode[2]["decodasc"][25] = ord("G");

  $Decode[2]["orgnlasc"][26] = ord("0"); $Decode[2]["decodasc"][26] = ord("J");
  $Decode[2]["orgnlasc"][27] = ord("1"); $Decode[2]["decodasc"][27] = ord("T");
  $Decode[2]["orgnlasc"][28] = ord("2"); $Decode[2]["decodasc"][28] = ord("Q");
  $Decode[2]["orgnlasc"][29] = ord("3"); $Decode[2]["decodasc"][29] = ord("E");
  $Decode[2]["orgnlasc"][30] = ord("4"); $Decode[2]["decodasc"][30] = ord("V");
  $Decode[2]["orgnlasc"][31] = ord("5"); $Decode[2]["decodasc"][31] = ord("H");
  $Decode[2]["orgnlasc"][32] = ord("6"); $Decode[2]["decodasc"][32] = ord("Z");
  $Decode[2]["orgnlasc"][33] = ord("7"); $Decode[2]["decodasc"][33] = ord("W");
  $Decode[2]["orgnlasc"][34] = ord("8"); $Decode[2]["decodasc"][34] = ord("M");
  $Decode[2]["orgnlasc"][35] = ord("9"); $Decode[2]["decodasc"][35] = ord("C");

  $Prm_TEMP = "";
  $Prm_INDEX = 0;
  $Prm_Asc = 0;
  $I = 0;
  $Prm_len = 0;
  $Prm_INDEX = 0;
  $Prm_Num = substr($Prm_pwd,-1);
  $Prm_pwd = substr($Prm_pwd,0, strlen($Prm_pwd) - 1);
  $Prm_len = strlen($Prm_pwd) + 1;

  While($Prm_len >= $Prm_INDEX){
   $Prm_Asc = ord(substr($Prm_pwd, $Prm_INDEX, 1));
      for($I = 0; $I <= 35; $I++){         
         if($Decode[$Prm_Num]["decodasc"][$I] == $Prm_Asc){
             $tmp = chr($Decode[$Prm_Num]["orgnlasc"][$I]);
             $Prm_TEMP = $Prm_TEMP . $tmp;
             break;
         }
      }
   $Prm_INDEX++;
  }
  return $Prm_TEMP;
}
?>
