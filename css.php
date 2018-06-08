<meta name="viewport" content="width=device-width">
<meta name="viewport" content="initial-scale=0.50">
<style> 

h3{
	text-align: center;
}
a{
color: black;
text-decoration: none;
}
.update {
   font-size:80%;
}
input[type=text] {
	font-size:100%;
	text-align: center;
    width: 80px;
    padding: 10px 0px;
    margin: 8px 0;
    box-sizing: border-box;
    border: none;
    border-bottom: 2px solid red;
}
.float{
	width: 33%;
	float: left;
	
	margin: auto;
}
@media screen and (max-width: 1000px) {
  .float {
    width: 100%; /* The width is 100%, when the viewport is 800px or smaller */
    padding:0 20%;
    float:center;
  }
  .float h3{
  text-align: left;
  }
}
.container {
   float: center;
    margin: auto;
    padding: 10px;
}
.summary {
   clear:both;
    float: left;
	padding: 10px;
	width: 100%;
}

/* Tooltip container */
.tooltip {
    position: relative;
    display: inline-block;
    
}

/* Tooltip text */
.tooltip .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    padding: 5px 0;
    border-radius: 6px;
 
    /* Position the tooltip text - see examples below! */
    position: absolute;
    z-index: 1;
}

/* Show the tooltip text when you mouse over the tooltip container */
.tooltip:hover .tooltiptext {
    visibility: visible;
}

</style>