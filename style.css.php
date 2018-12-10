<?php 
header("Content-type: text/css");
?>

*{font-family: 'Lato', sans-serif;}

@keyframes click-wave {
  0% {
    height: 40px;
    width: 40px;
    opacity: 0.35;
    position: relative;
  }
  100% {
    height: 200px;
    width: 200px;
    margin-left: -80px;
    margin-top: -80px;
    opacity: 0;
  }
}

input {
    width: 60px;
}

select {
	width: 220px;

}

.option-input {
  -webkit-appearance: none;
  -moz-appearance: none;
  -ms-appearance: none;
  -o-appearance: none;
  appearance: none;
  position: relative;
  top: 5px;
  right: 0;
  bottom: 0;
  left: 0;
  height: 20px;
  width: 20px;
  transition: all 0.15s ease-out 0s;
  background: #cbd1d8;
  border: none;
  color: #000000;
  cursor: pointer;
  display: inline-block;
  margin-right: 0.5rem;
  outline: none;
  position: relative;
  z-index: 1000;
}
.option-input:hover {
  background: #9faab7;
  background-color: RoyalBlue;	
}
.option-input:checked {
  background: #40e0d0;
}
.option-input:checked::before {
  height: 20px;
  width: 20px;
  position: absolute;
  content: '✔';
  display: inline-block;
  font-size: 12px;
  text-align: center;
  line-height: 20px;
}
.option-input:checked::after {
  -webkit-animation: click-wave 0.65s;
  -moz-animation: click-wave 0.65s;
  animation: click-wave 0.65s;
  background: #40e0d0;
  content: '';
  display: block;
  position: relative;
  z-index: 100;
}
.option-input.radio {
  border-radius: 50%;
}
.option-input.radio::after {
  border-radius: 50%;
}
#menu
{	background-color: rgba(1, 181, 255, 0.3);
	background: rgba(1, 181, 255, 0.3);
	color: rgba(f, f, f, f);
	border:inset 6px #050da1;
-moz-border-radius-topleft: 25px;
-moz-border-radius-topright:25px;
-moz-border-radius-bottomleft:25px;
-moz-border-radius-bottomright:25px;
-webkit-border-top-left-radius:25px;
-webkit-border-top-right-radius:25px;
-webkit-border-bottom-left-radius:25px;
-webkit-border-bottom-right-radius:25px;
border-top-left-radius:25px;
border-top-right-radius:25px;
border-bottom-left-radius:25px;
border-bottom-right-radius:25px;
	font-size: 24px;
	width: 120px;
	lenght: 200px;
	possition: absolute;
	padding: 150px;
	margin-left: auto;	
	margin-right: auto;
	margin-top: 30px;
	margin-: 100px;
}
 body { 	
  background-image: url("obrazytla/tlo.jpg");
   background-size: 1600px 830px;
 background-repeat: repeat;
	         width: 1000px;
  	         color: #000000;
       font-family:  "Lato", sans-serif;
        text-align: left;
  } 
body div {
  padding: 1rem;
}
body label {
  display: block;
  line-height: 40px;
}

.button2 {
  top: 13.33333px;
  right: 0;
  bottom: 0;
  left: 0;
}

.right {
    position: absolute;
    right: 50px;
    width: 100px;
    border: 1px solid orange;
    padding: 10px;
    background-color: RoyalBlue;
    text-align: center;
    
table, th, td {
   border: 1px solid black;
   text-align: center;
}

.options{
}
 	
.btn {
	 float: left;
    background-color: DodgerBlue;
    border: none;
    color: white;
    padding: 12px 16px;
    font-size: 16px;
    cursor: pointer;
}

.btn:hover {
    float: left;
}

#mainbox1
{
	background-color: rgba(1, 181, 255, 0.3);
	background: rgba(1, 181, 255, 0.3);
	color: rgba(f, f, f, f);
	border:inset 6px #050da1;
-moz-border-radius-topleft: 25px;
-moz-border-radius-topright:25px;
-moz-border-radius-bottomleft:25px;
-moz-border-radius-bottomright:25px;
-webkit-border-top-left-radius:25px;
-webkit-border-top-right-radius:25px;
-webkit-border-bottom-left-radius:25px;
-webkit-border-bottom-right-radius:25px;
border-top-left-radius:25px;
border-top-right-radius:25px;
border-bottom-left-radius:25px;
border-bottom-right-radius:25px;
	font-size: 24px;
	width: 120px;
	lenght: 200px;
	possition: absolute;
	padding: 150px;
	margin-left: auto;	
	margin-right: auto;
	margin-top: 30px;
	margin-: 100px;

}

#conteiner
{
	width: 1200px;
	margin-left: auto;	
	margin-right: auto;	 
}

#header
{	
	background-color: rgba(1, 181, 255, 0.3);
	margin:                             10px;
	font-size:         					44px;	
	font-weight:     				   900px;
	width:       					   100px;
	color:      					 #00000;
}

#central
{background-color: 				   red;

}
 	 	
#footer
{background-color: 				   blue;

}
