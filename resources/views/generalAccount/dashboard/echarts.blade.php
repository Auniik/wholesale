<div id="main" style="width:auto; height:400px;"></div>
<script src="{{asset('plugins/charts/echarts.min.js')}}"></script>
{{--@dd($data)--}}
<script type="text/javascript">
    function currentMonth() {
        var today = new Date(); // current date
        var end = new Date(today.getFullYear(), today.getMonth() + 1, 0).getDate(); // end date of month
        // var result = [];
        var days = [];
        for(let i = 1; i <= end; i++){
            // result.push(today.getFullYear() + '-' + (today.getMonth() < 10? '0'+today.getMonth(): today.getMonth()) +'-'+ (i < 10 ? '0'+ i: i))
            days.push(i)
        }

        return days;
    }
    // based on prepared DOM, initialize echarts instance
    var myChart = echarts.init(document.getElementById('main'));

    option = {
        title: {
            // text: 'Income Expense Chart',
            // subtext: 'Gross'
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data:['Income','Expense']
        },
        toolbox: {
            show: true,
            feature: {
                dataZoom: {
                    yAxisIndex: 'none'
                },
                dataView: {readOnly: false},
                magicType: {type: ['line', 'bar']},
                restore: {},
                saveAsImage: {}
            }
        },

        //
        xAxis:  {
            type: 'category',
            // boundaryGap: false,
            data: currentMonth()

        },
        yAxis: {
            type: 'value',
            axisLabel: {
                formatter: '{value} TK  '
            }
        },
        series: [
            {
                name:'Income',
                type:'line',
                data: [
                    @foreach($data as $amount)
                    {{$amount->amount.','}}
                    @endforeach

                ],
                markPoint: {
                    data: [
                        {type: 'max', name: 'max'},
                        {type: 'min', name: 'min'}
                    ]
                },
                // markLine: {
                //     data: [
                //         {type: 'average', name: 'Average'}
                //     ]
                // }
            },
            {
                name:'Expense',
                type:'line',
                data:[100, -20, 2000, 5000, 3000, 200, 600],
                markPoint: {
                    data: [
                        {name: '周最低', value: -2, xAxis: 1, yAxis: -1.5}
                    ]
                },
                // markLine: {
                //     data: [
                //         {type: 'average', name: 'average'},
                //         [{
                //             symbol: 'none',
                //             x: '90%',
                //             yAxis: 'max'
                //         }, {
                //             symbol: 'circle',
                //             label: {
                //                 normal: {
                //                     position: 'start',
                //                     formatter: 'max'
                //                 }
                //             },
                //             type: 'max',
                //             name: 'max'
                //         }]
                //     ]
                // }
            }
        ]
    };


    // use configuration item and data specified to show chart
    myChart.setOption(option);
</script>

<script>

    // console.log(currentMonth())

</script>