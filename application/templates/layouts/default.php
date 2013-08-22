<!DOCTYPE html>
<html lang="en">
<head>
<title>Open PHP CMS</title>
<style type="text/css">
body {
background-color: #fff;
margin: 40px;
font: 13px/20px normal Helvetica, Arial, sans-serif;
color: #4F5155;
}

a {
color: #003399;
font-weight: normal;
}

h1 {
color: #444;
border-bottom: 1px solid #D0D0D0;
font-size: 19px;
font-weight: normal;
margin: 0 0 14px 0;
padding: 14px 15px 10px 15px;
}

code {
font-family: Consolas, Monaco, Courier New, Courier, monospace;
font-size: 12px;
background-color: #f9f9f9;
border: 1px solid #D0D0D0;
color: #002166;
display: block;
margin: 14px 0 14px 0;
padding: 12px 10px 12px 10px;
}

#container {
margin: 10px;
border: 1px solid #D0D0D0;
}

p {
margin: 12px 15px 12px 15px;
}
</style>
</head>
<body>
<div id="container">
	<div><?PHP $this->menu();  ?></div>
	<div><?PHP $this->content();  ?></div>
</body>
</html>
