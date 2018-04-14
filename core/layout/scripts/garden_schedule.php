<?php
require_once(__DIR__.'/../../api/garden.php');
$plants = get_plants($_GET['id']);

header('Content-Type: application/javascript');
?>

	  var w = 800;
	  var h = 400;


	  var svg = d3.selectAll(".svg_container")
	  //.selectAll("svg")
	  .append("svg")
	  .attr("width", w)
	  .attr("height", h)
	  .attr("class", "svg");

		var taskArray = [
<?php
	$number_of_plants = $plants->rowCount();
	$count = 0;
	$date_conversion = new DateTime();
	foreach($plants as $plant) {
	  echo '{'.
		'task:' . '"' . $plant['name'] .'"' . ',' .
		'type:' . '"' . $plant['variety'] .'"' . ',' .
		'startTime:' . '"' . date('Y-m-d', strtotime($plant['plant_date'])) .'"' . ',';
		
		$date_conversion->setDate(date('Y', strtotime($plant['plant_date'])), date('m', strtotime($plant['plant_date'])), date('d', strtotime($plant['plant_date'])));
		$date_conversion->add(date_interval_create_from_date_string('"' . $plant['days_to_maturity'] . ' days"'));
		
	  echo	'endTime:' . '"' . $date_conversion->format('Y-m-d') .'"' . ',' .
		'details:' . '"Number of plantings: ' . $plant['number_of_plantings'] .'"' .
		'}';
		if($count < $number_of_plants) {
			echo ',';
		}
		$count++;
	}

	echo '];';
	?>

	var dateFormat = d3.time.format("%Y-%m-%d");

	var timeScale = d3.time.scale()
			.domain([d3.min(taskArray, function(d) {return dateFormat.parse(d.startTime);}),
					 d3.max(taskArray, function(d) {return dateFormat.parse(d.endTime);})])
			.range([0,w-150]);

	var categories = new Array();

	for (var i = 0; i < taskArray.length; i++){
		categories.push(taskArray[i].task);
	}

	var catsUnfiltered = categories; //for vert labels

	categories = checkUnique(categories);


	makeGant(taskArray, w, h);

	var title = svg.append("text")
				  .text("Planting Schedule")
				  .attr("x", w/2)
				  .attr("y", 25)
				  .attr("text-anchor", "middle")
				  .attr("font-size", 18)
				  .attr("fill", "#5a5a5a");



	function makeGant(tasks, pageWidth, pageHeight){

	var barHeight = 20;
	var gap = barHeight + 4;
	var topPadding = 75;
	var sidePadding = 175;

	var colorScale = d3.scale.linear()
		.domain([0, categories.length])
		//.range(["#00B9FA", "#F95002"])
		.range(['#008cbd', '#30ca00'])
		.interpolate(d3.interpolateHcl);

	makeGrid(sidePadding, topPadding, pageWidth, pageHeight);
	drawRects(tasks, gap, topPadding, sidePadding, barHeight, colorScale, pageWidth, pageHeight);
	vertLabels(gap, topPadding, sidePadding, barHeight, colorScale);

	}


	function drawRects(theArray, theGap, theTopPad, theSidePad, theBarHeight, theColorScale, w, h){

	var bigRects = svg.append("g")
		.selectAll("rect")
	   .data(theArray)
	   .enter()
	   .append("rect")
	   .attr("x", 0)
	   .attr("y", function(d, i){
		  return i*theGap + theTopPad - 2;
	  })
	   .attr("width", function(d){
		  return w-theSidePad/2;
	   })
	   .attr("height", theGap)
	   .attr("stroke", "none")
	   .attr("fill", function(d){
		for (var i = 0; i < categories.length; i++){
			if (d.task == categories[i]){
			  return d3.rgb(theColorScale(i));
			}
		}
	   })
	   .attr("opacity", 0.2);


		 var rectangles = svg.append('g')
		 .selectAll("rect")
		 .data(theArray)
		 .enter();


	   var innerRects = rectangles.append("rect")
				 .attr("rx", 3)
				 .attr("ry", 3)
				 .attr("x", function(d){
				  return timeScale(dateFormat.parse(d.startTime)) + theSidePad;
				  })
				 .attr("y", function(d, i){
					return i*theGap + theTopPad;
				})
				 .attr("width", function(d){
					return (timeScale(dateFormat.parse(d.endTime))-timeScale(dateFormat.parse(d.startTime)));
				 })
				 .attr("height", theBarHeight)
				 .attr("stroke", "none")
				 .attr("fill", function(d){
				  for (var i = 0; i < categories.length; i++){
					  if (d.task == categories[i]){
						return d3.rgb(theColorScale(i));
					  }
				  }
				 })


			 var rectText = rectangles.append("text")
				   .text(function(d){
					return d.type;
				   })
				   .attr("x", function(d){
					return (timeScale(dateFormat.parse(d.endTime))-timeScale(dateFormat.parse(d.startTime)))/2 + timeScale(dateFormat.parse(d.startTime)) + theSidePad;
					})
				   .attr("y", function(d, i){
					  return i*theGap + 14+ theTopPad;
				  })
				   .attr("font-size", 11)
				   .attr("text-anchor", "middle")
				   .attr("text-height", theBarHeight)
				   .attr("fill", "#fff");
	}


	function makeGrid(theSidePad, theTopPad, w, h){

	var xAxis = d3.svg.axis()
		.scale(timeScale)
		.orient('bottom')
		.ticks(d3.time.months, 1)
		.tickSize(-h+theTopPad+20, 0, 0)
		.tickFormat(d3.time.format('%b'));

	var grid = svg.append('g')
		.attr('class', 'grid')
		.attr('transform', 'translate(' +theSidePad + ', ' + (h - 50) + ')')
		.call(xAxis)
		.selectAll("text")  
				.style("text-anchor", "middle")
				.attr("fill", "#000")
				.attr("stroke", "none")
				.attr("font-size", 10)
				.attr("dy", "1em");
	}

	function vertLabels(theGap, theTopPad, theSidePad, theBarHeight, theColorScale){
	  var numOccurances = new Array();
	  var prevGap = 0;

	  for (var i = 0; i < categories.length; i++){
		numOccurances[i] = [categories[i], getCount(categories[i], catsUnfiltered)];
	  }

	  var axisText = svg.append("g") //without doing this, impossible to put grid lines behind text
	   .selectAll("text")
	   .data(numOccurances)
	   .enter()
	   .append("text")
	   .text(function(d){
		return d[0];
	   })
	   .attr("x", 10)
	   .attr("y", function(d, i){
		if (i > 0){
			for (var j = 0; j < i; j++){
			  prevGap += numOccurances[i-1][1];
			 // console.log(prevGap);
			  return d[1]*theGap/2 + prevGap*theGap + theTopPad;
			}
		} else{
		return d[1]*theGap/2 + theTopPad;
		}
	   })
	   .attr("font-size", 11)
	   .attr("text-anchor", "start")
	   .attr("text-height", 14)
	   .attr("fill", '#565656');

	}

	//from this stackexchange question: http://stackoverflow.com/questions/1890203/unique-for-arrays-in-javascript
	function checkUnique(arr) {
		var hash = {}, result = [];
		for ( var i = 0, l = arr.length; i < l; ++i ) {
			if ( !hash.hasOwnProperty(arr[i]) ) { //it works with objects! in FF, at least
				hash[ arr[i] ] = true;
				result.push(arr[i]);
			}
		}
		return result;
	}

	//from this stackexchange question: http://stackoverflow.com/questions/14227981/count-how-many-strings-in-an-array-have-duplicates-in-the-same-array
	function getCounts(arr) {
		var i = arr.length, // var to loop over
			obj = {}; // obj to store results
		while (i) obj[arr[--i]] = (obj[arr[i]] || 0) + 1; // count occurrences
		return obj;
	}

	// get specific from everything
	function getCount(word, arr) {
		return getCounts(arr)[word] || 0;
	}