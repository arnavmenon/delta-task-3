<?php
    header("Content-type: text/css; charset: UTF-8");
?>

.main {
  text-align: center;
  font-size: 28px;
  font-family:'Philosopher', sans-serif;
  margin-bottom: 50px;
}

.response{
  margin-left: 280px;
  margin-top: 50px;
  font-size: 28px;
  text-align: center;
  font-family:'Philosopher', sans-serif;
}

#acc,#rej{
  border: none;
  background: none;
  margin-left: 20px;
  margin-right: 20px;
  font-size: 30px;
  color: white;
  font-family:'Philosopher', sans-serif;
  border: none;
  border-radius: 8px;
  width: 120px;
  height: 40px;

}

h1{
  margin-bottom: 30px;
}

.dt{
  display:block;
  margin-left:auto;
  margin-right: auto;
  font-size: 30px;
  text-shadow: 1px 1px yellow;
}

#time,#date,#from{
  width: 25px;
}

#acc{
  background-color: green;
}

#rej{
  background-color: red;
}

#responseform{
  display: none;
}

.inputfield{
  margin-top: 20px;
  margin-bottom: 20px;
}

.fieldname{
  font-size: 25px;
}

#send{
  width: 10%;
  color: white;
  background-color: black;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 8px;
  font-size: 20px;
  font-family:'Philosopher', sans-serif;

}

input[type=text]{
  width: 50%;
  height: 40px;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 3px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
