
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

  <script src="{{ asset('assets/js/script.js') }}"></script>
  <script src="{{ asset('assets/js/noti.js') }}"></script>
  {{-- <script src="{{ asset('assets/js/noti.js') }}"></script> --}}
  <script src="https://kit.fontawesome.com/0f2939e7cf.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>


<script>
    // Wait for the entire window (images, styles, scripts) to finish loading
    window.addEventListener('load', function() {
        const loader = document.getElementById('page-loader');
        
        if (loader) {
            // Trigger the fade out
            loader.style.opacity = '0';
            loader.style.visibility = 'hidden';
            
            // Optional: Remove it entirely from the DOM after the 0.5s fade finishes
            setTimeout(() => {
                loader.remove();
            }, 500); 
        }
    });
</script>
</script>
</body>
</html>