<?php 
header("Content-type: text/css");
?>

*{font-family: 'Roboto', sans-serif;}

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
  top: 13.33333px;
  right: 0;
  bottom: 0;
  left: 0;
  height: 40px;
  width: 40px;
  transition: all 0.15s ease-out 0s;
  background: #cbd1d8;
  border: none;
  color: #fff;
  cursor: pointer;
  display: inline-block;
  margin-right: 0.5rem;
  outline: none;
  position: relative;
  z-index: 1000;
}
.option-input:hover {
  background: #9faab7;
  background-color: green;
}
.option-input:checked {
  background: #40e0d0;
}
.option-input:checked::before {
  height: 40px;
  width: 40px;
  position: absolute;
  content: '✔';
  display: inline-block;
  font-size: 26.66667px;
  text-align: center;
  line-height: 40px;
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

 body {
 
 <!--display: -webkit-box;
  display: -moz-box;
  display: -ms-flexbox;
  display: box; -->
  background: #e8ebee;
  color: #9faab7;
  font-family: "Helvetica Neue", "Helvetica", "Roboto", "Arial", sans-serif;
  text-align: left;
  } 
body div {
  padding: 5rem;
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

.limited-checkbox{
}

.limited-check{
}

.right {
    position: absolute;
    right: 50px;
    width: 100px;
    border: 1px solid orange;
    padding: 10px;
    background-color: orange;
    text-align: center;
    
table, th, td {
   border: 1px solid black;
   text-align: center;
}