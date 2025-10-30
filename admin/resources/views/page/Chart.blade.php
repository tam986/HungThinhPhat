 <!-- Form lọc dữ liệu -->
 <div class="container-fluid bg-white mt-4 p-3 mb-5 rounded shadow-sm">
     <form id="filterForm" class="d-flex align-items-center gap-3">
         <div class="form-group">
             <label for="fromDate" class="text-dark fw-semibold">Từ ngày:</label>
             <input type="date" id="fromDate" name="fromDate" class="form-control w-auto"
                 value="{{ now()->subMonth()->toDateString() }}">
         </div>
         <div class="form-group">
             <label for="toDate" class="text-dark fw-semibold">Đến ngày:</label>
             <input type="date" id="toDate" name="toDate" class="form-control w-auto"
                 value="{{ now()->toDateString() }}">
         </div>
         <button type="submit" class="btn btn-primary">Lọc</button>
     </form>

     <!-- Tabs -->
     <ul class="nav nav-tabs mt-3">
         <li class="nav-item">
             <a class="nav-link active" data-bs-toggle="tab" href="#ordersChart">Thống kê đơn hàng</a>
         </li>
         <li class="nav-item">
             <a class="nav-link" data-bs-toggle="tab" href="#revenueChart">Thống kê doanh thu</a>
         </li>
     </ul>

     <!-- Nội dung của từng Tab -->
     <div class="tab-content mt-3">
         <div id="ordersChart" class="tab-pane fade show active">
             <canvas id="ordersChartCanvas"></canvas>
         </div>
         <div id="revenueChart" class="tab-pane fade">
             <canvas id="revenueChartCanvas"></canvas>
         </div>
     </div>
 </div>
 @section('scripts')
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script>
         $(document).ready(function() {
             let ordersChart, revenueChart;

             function loadChartData(fromDate, toDate) {
                 $.ajax({
                     url: "{{ route('donhang.getChartData') }}",
                     method: "GET",
                     data: {
                         fromDate,
                         toDate
                     },
                     success: function(response) {
                         if (response.success === false) {
                             alert(response.message);
                             return;
                         }

                         const labels = response.labels.map(date => {
                             const [year, month, day] = date.split('-');
                             return `${day}/${month}`;
                         });
                         const orderData = response.orders;
                         const revenueData = response.revenue;

                         if (ordersChart) ordersChart.destroy();
                         if (revenueChart) revenueChart.destroy();

                         ordersChart = new Chart(document.getElementById("ordersChartCanvas").getContext(
                             "2d"), {
                             type: "bar",
                             data: {
                                 labels: labels,
                                 datasets: [{
                                     label: "Số đơn hàng",
                                     backgroundColor: "rgba(54, 162, 235, 0.5)",
                                     borderColor: "rgba(54, 162, 235, 1)",
                                     data: orderData,
                                     borderWidth: 1
                                 }]
                             },
                             options: {
                                 scales: {
                                     y: {
                                         beginAtZero: true
                                     }
                                 }
                             }
                         });

                         revenueChart = new Chart(document.getElementById("revenueChartCanvas")
                             .getContext("2d"), {
                                 type: "line",
                                 data: {
                                     labels: labels,
                                     datasets: [{
                                         label: "Doanh thu (VNĐ)",
                                         backgroundColor: "rgba(255, 99, 132, 0.5)",
                                         borderColor: "rgba(255, 99, 132, 1)",
                                         data: revenueData,
                                         fill: true
                                     }]
                                 },
                                 options: {
                                     scales: {
                                         y: {
                                             beginAtZero: true
                                         }
                                     }
                                 }
                             });
                     },
                     error: function() {
                         alert('Không thể tải dữ liệu biểu đồ. Vui lòng thử lại.');
                     }
                 });
             }

             // Tải dữ liệu ban đầu
             loadChartData('', '');

             // Xử lý form lọc
             $("#filterForm").on("submit", function(e) {
                 e.preventDefault();
                 const fromDate = $("#fromDate").val();
                 const toDate = $("#toDate").val();
                 if (fromDate && toDate && fromDate > toDate) {
                     alert('Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc.');
                     return;
                 }
                 loadChartData(fromDate, toDate);
             });
         });
     </script>
 @endsection
