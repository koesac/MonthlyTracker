<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{
  font-family: arial,sans-serif;
margin:0 10px;
padding-top: 50px;
}
ul {
    list-style-type: none;
    margin: 0 -10px;
    padding: 0;
    overflow: hidden;
    background-color: #fafafa;
    position: fixed;
    top: 0;
    width: 100%;
}

li {
    float: left;

}

li a {
    display: block;
    color: #666;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover:not(.active) {
    color: black;
}

.active {
    color: red;
    border-bottom: 3px solid red;
}
.box{
box-shadow: 0 2px 2px 0 rgba(0,0,0,0.16),0 0 0 1px rgba(0,0,0,0.08);
margin: 10px auto;
max-width: 700px;
border: 1px solid #fafafa;
border-radius: 4px;
padding: 5px;
position:relative;
}
.details{
  width:90%;
  display: inline-block;
}

.title{
  font-size: 150%;
  font-weight: bold;
  display:inline;
}
.price{
  color: grey;
  font-weight: lighter;
  display:inline;
}
.box:hover {
background-color:#fafafa;;
}
.box:hover + .title{
color:green;
}

.item {
    position:relative;
    padding-top:20px;
    display:inline-block;
}
.notify-badge a {

    position: absolute;
    right:-20px;
    top:-15px;
    text-align: center;
    border-radius: 30px 30px 30px 30px;
    color:white;
    padding:5px 10px;
    margin: 10px;
    font-size:20px;
}
.green a{background: green;}
.red a{background: red;}
.removed{text-decoration:line-through;}

h2{
  margin: 10px auto;
  max-width: 700px;
}
.title a:visited{
	color:blue;
}
</style>
<script charset="utf-8">
	function changetab() {
    var x = document.getElementById("gifts");
  
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

function changetab2() {

var x =    document.getElementByClassName("tab");
x.style.display = "none";

}
</script>

</head>
<body>
  <ul>
    <li><a class="active" onclick="changetab2()">Gift Ideas</a></li>
    <li><a href="#news"  onclick="changetab()">Shopping List</a></li>
    <li><a href="#contact">My Wish List</a></li>

  </ul>
  
<div class="tab" id="ideas">
<h2>Alex</h2>

<div id="myDIV" class="box">
  <div class="details">
      <div class="title"><a href="https://www.google.com">A pair of socks with a really long name</a></div>
      <div class="price">£10</div>
      <div class="description">They are really warm and fuzzy! I need them :) Like i really need them right fucking now. this is a really long line of text, i mean isnt it just the longest</div>
  </div>
  <span class="notify-badge"><a href="new">Claim</a></span>
</div>
<div class="box removed">
  <div class="details">
      <div class="title removed"><a href="https://www.google.com">A pair of socks</a></div>
      <div class="price">£10</div>
      <div class="description">They are really warm and fuzzy! I need them :) Like i really need them right fucking now. this is a really long line of text, i mean isnt it just the longest</div>
  </div>
  <span class="notify-badge red"><a href="new">Claim</a></span>
</div>
<div class="box">
  <div class="details">
      <div class="title"><a href="https://www.google.com">A pair of socks</a></div>
   		<div class="price">£10</div>
      
  </div>
  <span class="notify-badge green"><a href="new">Claim</a></span>
</div>
</div>
<div class="tab">
shopping list
person
return or purchase
</div>




</body>
</html>
