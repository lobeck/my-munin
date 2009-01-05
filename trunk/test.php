<!-- $Header: $ -->
<!-- $ Header: $ -->
<!-- $Id: $ -->
<!-- $ Id: $ -->
<!-- $Id$ -->
<html>
<head>
<script type="text/javascript" src="prototype.js"></script>
<script type="text/javascript" src="scriptaculous.js"></script>
</head>
<body>

<style>
#graphs { width:1100px }
</style>


<div id="graphs">
	<div id="graph_a" style="float: left; border: 1px dotted; padding: 2.5px; margin: 2.5px; display:block;">foo<br><img src="http://munin.becksrv.de/becksrv.de/main.becksrv.de-mysql_queries-day.png"></div>
	<div id="graph_b" style="float: left; border: 1px dotted; padding: 2.5px; margin: 2.5px; display:block;">bar<br><img src="http://munin.becksrv.de/becksrv.de/main.becksrv.de-mysql_queries-week.png"></div>
	<div id="graph_c" style="float: left; border: 1px dotted; padding: 2.5px; margin: 2.5px; display:block;">asd<br><img src="http://munin.becksrv.de/becksrv.de/main.becksrv.de-mysql_queries-month.png"></div>
	<div id="graph_d:1" style="float: left; border: 1px dotted; padding: 2.5px; margin: 2.5px; display:block;">efs<br><img src="http://munin.becksrv.de/becksrv.de/main.becksrv.de-mysql_queries-year.png"></div>
</div>
	<input type="submit" value="4321" onClick="changeSequence();" />
<input type="submit" value="reset" onClick="reset();" />
<input type="submit" value="save" onClick="save();" />
<input type="submit" value="smaller" onClick="smaller();" />
<input type="submit" value="bigger" onClick="bigger();" />
<p id="serialize">none</p>
<script type="text/javascript">
(function(){ 
	var info = $('serialize');

  Sortable.create('graphs', {
    tag:'div',overlap:'horizontal',constraint: false,
    onUpdate:function(){
       info.update(Sortable.sequence('graphs'));
    }
  });
})();

var graphs = $('graphs');
var info = $('serialize');

function changeSequence()
{
Sortable.setSequence('graphs',['4', '3', '2', '1']);
}
function reset()
{
Sortable.setSequence('graphs',['1', '2', '3', '4']);
}
function save()
{
	info.update(Sortable.sequence('graphs'));
}
function bigger()
{
	graphs.style.width = 2000;
}
function smaller()
{
	graphs.style.width = 600;
}
</script>


</body>
</html>