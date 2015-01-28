/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(function() {
    "use strict";

    //Make the dashboard widgets sortable Using jquery UI
    $(".connectedSortable").sortable({
        placeholder: "sort-highlight",
        connectWith: ".connectedSortable",
        handle: ".box-header, .nav-tabs",
        forcePlaceholderSize: true,
        zIndex: 999999
    }).disableSelection();
    $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");
    //jQuery UI sortable for the todo list
    $(".todo-list").sortable({
        placeholder: "sort-highlight",
        handle: ".handle",
        forcePlaceholderSize: true,
        zIndex: 999999
    }).disableSelection();
    ;

    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();

    $('.daterange').daterangepicker(
            {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                },
                startDate: moment().subtract('days', 29),
                endDate: moment()
            },

    function(start, end) {
        alert("You chose: " + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });

    /* jQueryKnob */
    $(".knob").knob();

    //World map by jvectormap
    //$('#world-map').vectorMap({
    //    map: 'ph_regions_mill_en',
    //    backgroundColor: "transparent",
    //    regionStyle: {
    //        initial: {
    //            fill: '#e4e4e4',
    //            "fill-opacity": 1,
    //            stroke: 'none',
    //            "stroke-width": 0,
    //            "stroke-opacity": 1
    //        }
    //    },
    //    series: {
    //        regions: [{
    //                values: utils.dashboard.listigingCountData,
    //                scale: ["#92c1dc", "#ebf4f9"],
    //                normalizeFunction: 'polynomial'
    //            }]
    //    },
    //    onRegionLabelShow: function(e, el, code) {
    //        if (typeof utils.dashboard.listigingCountData[code] != "undefined")
    //            el.html(el.html() + ': ' + utils.dashboard.listigingCountData[code] + ' Active Listings');
    //    }
    //});

    //The Calender
    $("#calendar").datepicker();

    //SLIMSCROLL FOR CHAT WIDGET
    $('#chat-box').slimScroll({
        height: '250px'
    });

    /* Morris.js Charts */
    // Sales chart
    var area = new Morris.Area({
        element: 'revenue-chart',
        resize: true,
        data: utils.dashboard.revenueChart,
        xkey: 'y',
        ykeys: ['revenue'],
        labels: ['Revenue'],
        lineColors: ['#a0d0e0'],
        hideHover: 'auto'
    });
//    var line = new Morris.Line({
//        element: 'line-chart',
//        resize: true,
//        data: [
//            {y: '2011 Q1', item1: 2666},
//            {y: '2011 Q2', item1: 2778},
//            {y: '2011 Q3', item1: 4912},
//            {y: '2011 Q4', item1: 3767},
//            {y: '2012 Q1', item1: 6810},
//            {y: '2012 Q2', item1: 5670},
//            {y: '2012 Q3', item1: 4820},
//            {y: '2012 Q4', item1: 15073},
//            {y: '2013 Q1', item1: 10687},
//            {y: '2013 Q2', item1: 8432}
//        ],
//        xkey: 'y',
//        ykeys: ['item1'],
//        labels: ['Item 1'],
//        lineColors: ['#efefef'],
//        lineWidth: 2,
//        hideHover: 'auto',
//        gridTextColor: "#fff",
//        gridStrokeWidth: 0.4,
//        pointSize: 4,
//        pointStrokeColors: ["#efefef"],
//        gridLineColor: "#efefef",
//        gridTextFamily: "Open Sans",
//        gridTextSize: 10
//    });
//
//    //Donut Chart
//    var donut = new Morris.Donut({
//        element: 'sales-chart',
//        resize: true,
//        colors: ["#3c8dbc", "#f56954", "#00a65a"],
//        data: [
//            {label: "Download Sales", value: 12},
//            {label: "In-Store Sales", value: 30},
//            {label: "Mail-Order Sales", value: 20}
//        ],
//        hideHover: 'auto'
//    });
//    //Bar chart
//    var bar = new Morris.Bar({
//        element: 'bar-chart',
//        resize: true,
//        data: [
//            {y: '2006', a: 100, b: 90},
//            {y: '2007', a: 75, b: 65},
//            {y: '2008', a: 50, b: 40},
//            {y: '2009', a: 75, b: 65},
//            {y: '2010', a: 50, b: 40},
//            {y: '2011', a: 75, b: 65},
//            {y: '2012', a: 100, b: 90}
//        ],
//        barColors: ['#00a65a', '#f56954'],
//        xkey: 'y',
//        ykeys: ['a', 'b'],
//        labels: ['CPU', 'DISK'],
//        hideHover: 'auto'
//    });

    //Fix for charts under tabs
    $('.box ul.nav a').on('shown.bs.tab', function(e) {
        area.redraw();
        donut.redraw();
    });


    /* BOX REFRESH PLUGIN EXAMPLE (usage with morris charts) */
    $("#loading-example").boxRefresh({
        source: "ajax/dashboard-boxrefresh-demo.php",
        onLoadDone: function(box) {
            bar = new Morris.Bar({
                element: 'bar-chart',
                resize: true,
                data: [
                    {y: '2006', a: 100, b: 90},
                    {y: '2007', a: 75, b: 65},
                    {y: '2008', a: 50, b: 40},
                    {y: '2009', a: 75, b: 65},
                    {y: '2010', a: 50, b: 40},
                    {y: '2011', a: 75, b: 65},
                    {y: '2012', a: 100, b: 90}
                ],
                barColors: ['#00a65a', '#f56954'],
                xkey: 'y',
                ykeys: ['a', 'b'],
                labels: ['CPU', 'DISK'],
                hideHover: 'auto'
            });
        }
    });

    /* The todo list plugin */
    $(".todo-list").todolist({
        onCheck: function(ele) {
            //console.log("The element has been checked")
        },
        onUncheck: function(ele) {
            //console.log("The element has been unchecked")
        }
    });

});