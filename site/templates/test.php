<html>
<head>
<style>
div.header {
    display: block; text-align: center; 
    position: running(header);
}
div.footer {
    display: block; text-align: center;
    position: running(footer);
}
@page {
    @top-center { content: element(header) }
}
@page { 
    @bottom-center { content: element(footer) }
}
</style>
</head>
<body>
    <div class='header'>Header</div>
    <div class='footer'>Footer</div>
</body>
</html>
