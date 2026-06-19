<x-app-layout>
    @php
        $summary = $summary ?? ['total_sales'=>0,'total_income'=>0,'total_expenses'=>0,'net_profit'=>0];
        $trendLabels=$trendLabels??[];$salesData=$salesData??[];$incomeData=$incomeData??[];
        $expensesData=$expensesData??[];$profitData=$profitData??[];
        $distribution=$distribution??['sales'=>0,'other_income'=>0,'expenses'=>0];
        $smartSuggestions=$smartSuggestions??[];$period=$period??'monthly';
        $reportPeriodLabel=$reportPeriodLabel??ucfirst($period);$reportRange=$reportRange??'-';
        $totalRevenue=$summary['total_sales']+$summary['total_income'];
        $profitMargin=$totalRevenue>0?($summary['net_profit']/$totalRevenue)*100:0;
        $expenseRatio=$totalRevenue>0?($summary['total_expenses']/$totalRevenue)*100:0;
        $bestProfit=count($profitData)>0?max($profitData):0;
        $worstProfit=count($profitData)>0?min($profitData):0;
        $averageProfit=count($profitData)>0?array_sum($profitData)/count($profitData):0;
    @endphp

    <div class="flex min-h-screen bg-gradient-to-br from-blue-50 via-slate-50 to-indigo-100">
        <x-sidebar />
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden" onclick="closeSidebar()"></div>

        <main class="flex-1 min-w-0 overflow-x-hidden">

            {{-- Header --}}
            <header class="bg-white/90 backdrop-blur border-b border-white/70 px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
                <div class="flex items-start gap-3 mb-4">
                    <button class="lg:hidden flex flex-col justify-center items-center w-9 h-9 gap-1.5 rounded-lg hover:bg-gray-100 transition shrink-0 mt-0.5" onclick="openSidebar()">
                        <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                        <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                        <span class="w-5 h-0.5 bg-gray-700 rounded"></span>
                    </button>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-xl sm:text-3xl font-bold text-slate-900">Profit & Loss Report</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 hidden sm:block">Clear overview of your sales, expenses, profit, and smart business suggestions</p>
                        <div class="mt-2 flex flex-wrap gap-2 text-xs">
                            <span class="rounded-full bg-blue-50 px-3 py-1 font-semibold text-blue-700">{{ $reportPeriodLabel }}</span>
                            <span class="rounded-full bg-slate-100 px-3 py-1 font-semibold text-slate-600">{{ $reportRange }}</span>
                        </div>
                    </div>
                </div>

                {{-- Period tabs + PDF button --}}
                <div class="flex flex-wrap gap-2 sm:gap-3">
                    @foreach(['daily'=>'Daily','weekly'=>'Weekly','monthly'=>'Monthly','yearly'=>'Yearly'] as $key=>$label)
                        <a href="{{ route('reports.index', $key) }}"
                           class="rounded-xl px-3 sm:px-5 py-2 sm:py-3 text-xs sm:text-sm font-semibold transition
                           {{ $period===$key ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-100' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                    <form id="pdfDownloadForm" method="POST" action="{{ route('reports.pdf', $period) }}">
                        @csrf
                        <input type="hidden" name="sales_expense_chart" id="sales_expense_chart">
                        <input type="hidden" name="distribution_chart"  id="distribution_chart">
                        <input type="hidden" name="profit_chart"        id="profit_chart">
                        <button type="submit" class="rounded-xl bg-red-600 px-3 sm:px-5 py-2 sm:py-3 text-xs sm:text-sm font-semibold text-white shadow-md shadow-red-200 hover:bg-red-700 transition">
                            Download PDF
                        </button>
                    </form>
                </div>
            </header>

            <div class="p-4 sm:p-6 lg:p-8 space-y-5 sm:space-y-8">

                {{-- Summary Cards --}}
                <div class="grid grid-cols-2 xl:grid-cols-4 gap-3 sm:gap-5">
                    <div class="rounded-3xl bg-white/95 backdrop-blur border border-white/70 p-4 sm:p-6 shadow-sm">
                        <p class="text-xs sm:text-sm font-medium text-slate-500">Total Sales</p>
                        <h3 class="mt-2 sm:mt-3 text-xl sm:text-3xl font-bold text-blue-600">RM{{ number_format($summary['total_sales'],2) }}</h3>
                        <p class="mt-1 sm:mt-2 text-xs text-slate-400 hidden sm:block">Product sales recorded</p>
                    </div>
                    <div class="rounded-3xl bg-white/95 backdrop-blur border border-white/70 p-4 sm:p-6 shadow-sm">
                        <p class="text-xs sm:text-sm font-medium text-slate-500">Other Income</p>
                        <h3 class="mt-2 sm:mt-3 text-xl sm:text-3xl font-bold text-green-600">RM{{ number_format($summary['total_income'],2) }}</h3>
                        <p class="mt-1 sm:mt-2 text-xs text-slate-400 hidden sm:block">Non-product income</p>
                    </div>
                    <div class="rounded-3xl bg-white/95 backdrop-blur border border-white/70 p-4 sm:p-6 shadow-sm">
                        <p class="text-xs sm:text-sm font-medium text-slate-500">Total Expenses</p>
                        <h3 class="mt-2 sm:mt-3 text-xl sm:text-3xl font-bold text-red-500">RM{{ number_format($summary['total_expenses'],2) }}</h3>
                        <p class="mt-1 sm:mt-2 text-xs text-slate-400 hidden sm:block">All expenses recorded</p>
                    </div>
                    <div class="rounded-3xl bg-white/95 backdrop-blur border border-white/70 p-4 sm:p-6 shadow-sm">
                        <p class="text-xs sm:text-sm font-medium text-slate-500">Net Profit</p>
                        <h3 class="mt-2 sm:mt-3 text-xl sm:text-3xl font-bold {{ $summary['net_profit']>=0?'text-emerald-600':'text-red-600' }}">RM{{ number_format($summary['net_profit'],2) }}</h3>
                        <p class="mt-1 sm:mt-2 text-xs text-slate-400 hidden sm:block">Revenue minus expenses</p>
                    </div>
                </div>

                {{-- Ratio Cards --}}
                <div class="grid gap-3 sm:gap-5 sm:grid-cols-2">
                    <div class="rounded-3xl bg-white/95 backdrop-blur border border-white/70 p-4 sm:p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-xs sm:text-sm font-medium text-slate-500">Profit Margin</p>
                                <h3 class="mt-2 sm:mt-3 text-2xl sm:text-3xl font-bold {{ $profitMargin>=15?'text-emerald-600':($profitMargin>=5?'text-orange-500':'text-red-500') }}">{{ number_format($profitMargin,2) }}%</h3>
                            </div>
                            <span class="rounded-full px-3 sm:px-4 py-1.5 sm:py-2 text-xs font-semibold {{ $profitMargin>=15?'bg-green-100 text-green-700':($profitMargin>=5?'bg-orange-100 text-orange-700':'bg-red-100 text-red-700') }}">
                                {{ $profitMargin>=15?'Healthy':($profitMargin>=5?'Moderate':'Low') }}
                            </span>
                        </div>
                        <p class="mt-2 sm:mt-3 text-xs sm:text-sm text-slate-500">Shows how much profit is made from your total revenue.</p>
                    </div>
                    <div class="rounded-3xl bg-white/95 backdrop-blur border border-white/70 p-4 sm:p-6 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-xs sm:text-sm font-medium text-slate-500">Expense Ratio</p>
                                <h3 class="mt-2 sm:mt-3 text-2xl sm:text-3xl font-bold {{ $expenseRatio>=90?'text-red-500':($expenseRatio>=75?'text-orange-500':'text-blue-600') }}">{{ number_format($expenseRatio,2) }}%</h3>
                            </div>
                            <span class="rounded-full px-3 sm:px-4 py-1.5 sm:py-2 text-xs font-semibold {{ $expenseRatio>=90?'bg-red-100 text-red-700':($expenseRatio>=75?'bg-orange-100 text-orange-700':'bg-blue-100 text-blue-700') }}">
                                {{ $expenseRatio>=90?'Very High':($expenseRatio>=75?'High':'Controlled') }}
                            </span>
                        </div>
                        <p class="mt-2 sm:mt-3 text-xs sm:text-sm text-slate-500">Shows how much of your revenue is used to cover expenses.</p>
                    </div>
                </div>

                {{-- Smart Suggestions --}}
                <div class="rounded-3xl bg-white/95 backdrop-blur border border-white/70 p-4 sm:p-6 shadow-sm">
                    <div class="mb-4 sm:mb-5 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-base sm:text-xl font-bold text-slate-900">Smart Business Suggestions</h3>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1">Rule-based insights for {{ $reportPeriodLabel }} period.</p>
                        </div>
                        <span class="self-start inline-flex rounded-full bg-blue-50 px-3 sm:px-4 py-1.5 sm:py-2 text-xs font-semibold text-blue-700">Rule-Based Insight</span>
                    </div>
                    @if(empty($smartSuggestions))
                        <div class="rounded-2xl bg-slate-50 p-4 sm:p-5 text-xs sm:text-sm text-slate-500">No suggestions available yet. Add more transactions to generate useful business insights.</div>
                    @else
                        <div class="grid gap-3 sm:gap-4 sm:grid-cols-2">
                            @foreach($smartSuggestions as $suggestion)
                                @php
                                    $type=$suggestion['type']??'warning';
                                    $boxClass=match($type){'success'=>'bg-green-50 border-green-200','danger'=>'bg-red-50 border-red-200',default=>'bg-orange-50 border-orange-200'};
                                    $titleClass=match($type){'success'=>'text-green-700','danger'=>'text-red-700',default=>'text-orange-700'};
                                    $badgeClass=match($type){'success'=>'bg-green-100 text-green-700','danger'=>'bg-red-100 text-red-700',default=>'bg-orange-100 text-orange-700'};
                                    $icon=match($type){'success'=>'✅','danger'=>'⚠️',default=>'💡'};
                                    $label=match($type){'success'=>'Good','danger'=>'Critical',default=>'Attention'};
                                @endphp
                                <div class="rounded-2xl border p-4 sm:p-5 {{ $boxClass }}">
                                    <div class="flex items-start justify-between gap-2">
                                        <h4 class="font-bold text-sm {{ $titleClass }}">{{ $icon }} {{ $suggestion['title'] }}</h4>
                                        <span class="shrink-0 rounded-full px-2 sm:px-3 py-1 text-xs font-semibold {{ $badgeClass }}">{{ $label }}</span>
                                    </div>
                                    <p class="mt-2 sm:mt-3 text-xs sm:text-sm leading-6 text-slate-700">{{ $suggestion['message'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Performance Cards --}}
                <div class="grid gap-3 sm:gap-5 grid-cols-3">
                    <div class="rounded-3xl bg-white/95 backdrop-blur border border-white/70 p-4 sm:p-6 shadow-sm">
                        <p class="text-xs sm:text-sm font-medium text-slate-500">Best Period</p>
                        <h3 class="mt-2 sm:mt-3 text-base sm:text-2xl font-bold text-green-600">RM{{ number_format($bestProfit,2) }}</h3>
                    </div>
                    <div class="rounded-3xl bg-white/95 backdrop-blur border border-white/70 p-4 sm:p-6 shadow-sm">
                        <p class="text-xs sm:text-sm font-medium text-slate-500">Worst Period</p>
                        <h3 class="mt-2 sm:mt-3 text-base sm:text-2xl font-bold text-red-500">RM{{ number_format($worstProfit,2) }}</h3>
                    </div>
                    <div class="rounded-3xl bg-white/95 backdrop-blur border border-white/70 p-4 sm:p-6 shadow-sm">
                        <p class="text-xs sm:text-sm font-medium text-slate-500">Average</p>
                        <h3 class="mt-2 sm:mt-3 text-base sm:text-2xl font-bold text-blue-600">RM{{ number_format($averageProfit,2) }}</h3>
                    </div>
                </div>

                {{-- Charts --}}
                <div class="grid gap-4 sm:gap-6 xl:grid-cols-2">
                    <div class="rounded-3xl bg-white/95 backdrop-blur border border-white/70 p-4 sm:p-6 shadow-sm">
                        <h3 class="text-base sm:text-xl font-bold text-slate-900 mb-1">Sales vs Expenses</h3>
                        <p class="text-xs sm:text-sm text-slate-500 mb-4">Compare money earned against business spending.</p>
                        @if(count($trendLabels)===0)
                            <div class="flex h-48 sm:h-[300px] items-center justify-center rounded-2xl bg-slate-50 text-slate-500 text-sm">No data available</div>
                        @else
                            <div class="relative h-48 sm:h-[300px] w-full"><canvas id="salesExpenseChart"></canvas></div>
                        @endif
                    </div>
                    <div class="rounded-3xl bg-white/95 backdrop-blur border border-white/70 p-4 sm:p-6 shadow-sm">
                        <h3 class="text-base sm:text-xl font-bold text-slate-900 mb-1">Financial Distribution</h3>
                        <p class="text-xs sm:text-sm text-slate-500 mb-4">Breakdown of sales, income, and expenses.</p>
                        @if(($distribution['sales']+$distribution['other_income']+$distribution['expenses'])<=0)
                            <div class="flex h-48 sm:h-[300px] items-center justify-center rounded-2xl bg-slate-50 text-slate-500 text-sm">No data available</div>
                        @else
                            <div class="relative h-48 sm:h-[300px] w-full"><canvas id="distributionChart"></canvas></div>
                            <div class="mt-4 space-y-2 text-xs sm:text-sm">
                                <div class="flex justify-between"><span class="flex items-center gap-2 text-slate-600"><span class="h-2.5 w-2.5 sm:h-3 sm:w-3 rounded-full bg-blue-600"></span>Sales</span><span class="font-semibold text-slate-900">RM{{ number_format($distribution['sales'],2) }}</span></div>
                                <div class="flex justify-between"><span class="flex items-center gap-2 text-slate-600"><span class="h-2.5 w-2.5 sm:h-3 sm:w-3 rounded-full bg-green-500"></span>Other Income</span><span class="font-semibold text-slate-900">RM{{ number_format($distribution['other_income'],2) }}</span></div>
                                <div class="flex justify-between"><span class="flex items-center gap-2 text-slate-600"><span class="h-2.5 w-2.5 sm:h-3 sm:w-3 rounded-full bg-red-500"></span>Expenses</span><span class="font-semibold text-slate-900">RM{{ number_format($distribution['expenses'],2) }}</span></div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Profit Trend --}}
                <div class="rounded-3xl bg-white/95 backdrop-blur border border-white/70 p-4 sm:p-6 shadow-sm">
                    <div class="mb-4 sm:mb-5 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-base sm:text-xl font-bold text-slate-900">Net Profit Trend</h3>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1">Profit shown separately for clarity.</p>
                        </div>
                        <div class="self-start rounded-full px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold {{ $summary['net_profit']>=0?'bg-green-50 text-green-700':'bg-red-50 text-red-700' }}">
                            {{ $summary['net_profit']>=0?'Profitable':'Loss' }}
                        </div>
                    </div>
                    @if(count($trendLabels)===0)
                        <div class="flex h-48 sm:h-[300px] items-center justify-center rounded-2xl bg-slate-50 text-slate-500 text-sm">No data available</div>
                    @else
                        <div class="relative h-48 sm:h-[300px] w-full"><canvas id="profitChart"></canvas></div>
                    @endif
                </div>

            </div>
        </main>
    </div>

    <script>let salesExpenseChartInstance=null,distributionChartInstance=null,profitChartInstance=null;</script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @if(count($trendLabels)>0)
    <script>
        const labels=@json($trendLabels),salesData=@json($salesData),expensesData=@json($expensesData),profitData=@json($profitData);
        const moneyFormat=(v)=>'RM'+Number(v).toFixed(2);
        const sec=document.getElementById('salesExpenseChart');
        if(sec){const ctx=sec.getContext('2d');const bg=ctx.createLinearGradient(0,0,0,340);bg.addColorStop(0,'rgba(37,99,235,0.25)');bg.addColorStop(1,'rgba(37,99,235,0)');const rg=ctx.createLinearGradient(0,0,0,340);rg.addColorStop(0,'rgba(239,68,68,0.25)');rg.addColorStop(1,'rgba(239,68,68,0)');salesExpenseChartInstance=new Chart(sec,{type:'line',data:{labels,datasets:[{label:'Sales',data:salesData,borderColor:'#2563EB',backgroundColor:bg,borderWidth:3,tension:0.35,fill:true,pointRadius:4,pointHoverRadius:6},{label:'Expenses',data:expensesData,borderColor:'#EF4444',backgroundColor:rg,borderWidth:3,tension:0.35,fill:true,pointRadius:4,pointHoverRadius:6}]},options:{responsive:true,maintainAspectRatio:false,interaction:{mode:'index',intersect:false},plugins:{legend:{position:'bottom',labels:{usePointStyle:true,boxWidth:8}},tooltip:{callbacks:{label:(c)=>c.dataset.label+': '+moneyFormat(c.raw)}}},scales:{y:{beginAtZero:true,ticks:{callback:(v)=>'RM'+v},grid:{color:'#E5E7EB'}},x:{grid:{display:false}}}}});}
        const pc=document.getElementById('profitChart');
        if(pc){profitChartInstance=new Chart(pc,{type:'bar',data:{labels,datasets:[{label:'Net Profit',data:profitData,backgroundColor:profitData.map(v=>v>=0?'#22C55E':'#EF4444'),borderRadius:10,barThickness:35}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false},tooltip:{callbacks:{label:(c)=>'Net Profit: '+moneyFormat(c.raw)}}},scales:{y:{ticks:{callback:(v)=>'RM'+v},grid:{color:'#E5E7EB'}},x:{grid:{display:false}}}}});}
    </script>
    @endif

    @if(($distribution['sales']+$distribution['other_income']+$distribution['expenses'])>0)
    <script>
        const dc=document.getElementById('distributionChart');
        if(dc){distributionChartInstance=new Chart(dc,{type:'doughnut',data:{labels:['Sales','Other Income','Expenses'],datasets:[{data:[{{ $distribution['sales'] }},{{ $distribution['other_income'] }},{{ $distribution['expenses'] }}],backgroundColor:['#2563EB','#22C55E','#EF4444'],borderWidth:4,borderColor:'#FFFFFF',hoverOffset:8}]},options:{responsive:true,maintainAspectRatio:false,cutout:'62%',plugins:{legend:{position:'bottom',labels:{usePointStyle:true,boxWidth:8}},tooltip:{callbacks:{label:(c)=>c.label+': RM'+Number(c.raw).toFixed(2)}}}}});}
    </script>
    @endif

    <script>
        const pdf=document.getElementById('pdfDownloadForm');
        if(pdf){pdf.addEventListener('submit',function(){if(salesExpenseChartInstance)document.getElementById('sales_expense_chart').value=salesExpenseChartInstance.toBase64Image();if(distributionChartInstance)document.getElementById('distribution_chart').value=distributionChartInstance.toBase64Image();if(profitChartInstance)document.getElementById('profit_chart').value=profitChartInstance.toBase64Image();});}
        function openSidebar(){document.getElementById('mobileSidebar').classList.remove('-translate-x-full');document.getElementById('sidebarOverlay').classList.remove('hidden');}
        function closeSidebar(){document.getElementById('mobileSidebar').classList.add('-translate-x-full');document.getElementById('sidebarOverlay').classList.add('hidden');}
    </script>
</x-app-layout>