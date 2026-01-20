
<!-- Main Footer -->
<footer class="fixed bottom-0 left-0 z-20 w-full p-4 bg-white border-t border-gray-200 shadow md:flex md:items-center md:justify-between md:p-6 dark:bg-gray-800 dark:border-gray-600 sm:ml-64">
    <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">
        &copy; <?= date("Y"); ?> <a href="index.php?dashboard" class="hover:underline">School Management System</a>. All Rights Reserved.
    </span>
</footer>

<!-- Flowbite JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Initialize DataTable (Generic) -->
<script>
    $(document).ready(function() {
        // Check if table exists before initializing
        if ($('#my-dataTable').length) {
            new DataTable('#my-dataTable', {
                responsive: true
            });
        }
    });

    // Sidebar Active State Logic
    $(document).ready(function() {
        let currentUrl = window.location.href;
        $(".nav-link").each(function() {
            let linkUrl = $(this).attr('href');
            // Check if current URL contains the link URL query string (simple check)
            // Need to handle full URL vs relative URL
            if (currentUrl.indexOf(linkUrl) !== -1) {
                $(this).addClass('bg-gray-100 dark:bg-gray-700 text-indigo-600 dark:text-white');
                $(this).find('i').addClass('text-indigo-600 dark:text-white').removeClass('text-gray-500');
            }
        });
    });
</script>

</body>
</html>