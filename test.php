<script>
    const path = window.location.pathname;
    const match = path.match(/product\/(\d+)/);
    const productId = match ? match[1] : null;

    console.log(productId); // "13"

</script>