(()=>{function r(r){var i=$(r).attr("data-colors");return(i=JSON.parse(i)).map((function(r){var i=r.replace(" ","");if(-1==i.indexOf("--"))return i;var e=getComputedStyle(document.documentElement).getPropertyValue(i);return e||void 0}))}$(document).ready((function(){var i,e=function(){var i=r("#sparkline1");$("#sparkline1").sparkline([20,40,30],{type:"pie",height:"200",resize:!0,sliceColors:i});var e=r("#sparkline2");$("#sparkline2").sparkline([5,6,2,8,9,4,7,10,11,12,10,4,7,10],{type:"bar",height:"200",barWidth:10,barSpacing:7,barColor:e});var o=r("#sparkline3");$("#sparkline3").sparkline([5,6,2,9,4,7,10,12,4,7,10],{type:"bar",height:"200",barWidth:"10",resize:!0,barSpacing:"7",barColor:o[0]}),$("#sparkline3").sparkline([5,6,2,9,4,7,10,12,4,7,10],{type:"line",height:"200",lineColor:o[1],fillColor:"transparent",composite:!0,lineWidth:2,highlightLineColor:"rgba(0,0,0,.1)",highlightSpotColor:"rgba(0,0,0,.2)"});var l=r("#sparkline4");$("#sparkline4").sparkline([0,23,43,35,44,45,56,37,40,45,56,7,10],{type:"line",width:"100%",height:"200",lineColor:l,fillColor:"transparent",spotColor:l,lineWidth:2,minSpotColor:void 0,maxSpotColor:void 0,highlightSpotColor:void 0,highlightLineColor:void 0});var a=r("#sparkline5");$("#sparkline5").sparkline([15,23,55,35,54,45,66,47,30],{type:"line",width:"100%",height:"200",chartRangeMax:50,resize:!0,lineColor:a[0],fillColor:a[1],highlightLineColor:"rgba(0,0,0,.1)",highlightSpotColor:"rgba(0,0,0,.2)"}),$("#sparkline5").sparkline([0,13,10,14,15,10,18,20,0],{type:"line",width:"100%",height:"200",chartRangeMax:40,lineColor:a[2],fillColor:a[3],composite:!0,resize:!0,highlightLineColor:"rgba(0,0,0,.1)",highlightSpotColor:"rgba(0,0,0,.2)"});var t=r("#sparkline6");$("#sparkline6").sparkline([4,6,7,7,4,3,2,1,4,4,5,6,3,4,5,8,7,6,9,3,2,4,1,5,6,4,3,7],{type:"discrete",width:"280",height:"200",lineColor:t});var n=r("#sparkline7");$("#sparkline7").sparkline([10,12,12,9,7],{type:"bullet",width:"280",height:"80",targetColor:n[0],performanceColor:n[1]});var p=r("#sparkline8");$("#sparkline8").sparkline([4,27,34,52,54,59,61,68,78,82,85,87,91,93,100],{type:"box",width:"280",height:"80",boxLineColor:p,boxFillColor:"#fbfaff",whiskerColor:p,outlierLineColor:p,medianColor:p,targetColor:p});var h=r("#sparkline9");$("#sparkline9").sparkline([1,1,0,1,-1,-1,1,-1,0,0,1,1],{height:"80",width:"100%",type:"tristate",posBarColor:h[0],negBarColor:h[1],zeroBarColor:h[2],barWidth:8,barSpacing:3,zeroAxis:!1})};$(window).resize((function(r){clearTimeout(i),i=setTimeout(e,500)})),e()}))})();