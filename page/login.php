<?php
include("../fct/fonctions.php");
writehead();
if (isset($_GET['success'])) $success=$_GET['success'];
else $success=0;
if (isset($_GET['error'])) $error=$_GET['error'];
else $error=0;

    echo "<div class='container-fluid' align=center style='display:inline-block'>
                <div class='col-sm-4' align=center style='margin-top:5%' >
                    <div class='card hide card-default graycarddefault' align=center style=''>
            <div class='card-header graycard'>
            <div class='card-title'><strong> Login </strong></div>
            </div>
                <div class='card-body graycard'><form action=\"../fct/connect.php\" method='POST'>";
                if ($success==1) echo "<div style='color:green'>Account created !</div><br>";
                 if ($error==2) echo "<div style='color:red'>Wrong login/password, please try again</div><br>";
                  if ($error==3) echo "<div style='color:red'>Logout due to inactivity time</div><br>";



                echo "<table class='noBorder'>
                <tr>
                <td style='padding-bottom:50px'> Login : </td><td style='padding-bottom:50px'> 
                    <input type=text class='login-field' name='login'value='Login'></input></td>
                </tr>
                 <tr>
                 <td>  Password :</td><td> <input type=password class='login-field' name='password' value='Password'></input></td>
                 </tr>
                   </table>";

          echo "</div>
          <div class='card-footer'>
                <button type='submit' class='btn btn-light'>Login</button>
                <button type='button' class='btn btn-light' onclick='location.href=\"newAccount.php\"'>New account</button>
          </div>
          </form>
          </div>";