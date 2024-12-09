</body>
    <script src="./assets/acad.js" ></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<?php
  if(isset($_SESSION['status']) && $_SESSION['status_code'] !='') {
      ?>
      <script>
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
          }
        });
        Toast.fire({
          icon: "<?php echo $_SESSION['status_code']; ?>",
          title: "<?php echo $_SESSION['status']; ?>"
        });
      </script>
      <?php
      unset($_SESSION['status']);
      unset($_SESSION['status_code']);
  }     
?>

    <script>
		let profileDropdownList = document.querySelector(".profile-dropdown-list");
		let btn = document.querySelector(".profile-dropdown-btn");

		let classList = profileDropdownList.classList;

		const toggle = () => classList.toggle("active");

		window.addEventListener("click", function (e) {
		if (!btn.contains(e.target)) classList.remove("active");
		});

		document.addEventListener('DOMContentLoaded', () => {
    const importButton = document.getElementById('importButton');
    const importModal = document.getElementById('importModal');
    const closeButton = importModal.querySelector('.close');

    importButton.addEventListener('click', () => {
        importModal.style.display = 'block';
    });

    closeButton.addEventListener('click', () => {
        importModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === importModal) {
            importModal.style.display = 'none';
        }
    });
});

	</script>

</html>