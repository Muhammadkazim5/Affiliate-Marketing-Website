@section('customcss')
<style>
    .custom-alert {
    border-radius: 15px; /* Rounded corners */
    padding: 20px;       /* Add spacing */
    font-size: 1rem;     /* Adjust font size */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow */
    transition: all 0.3s ease-in-out; /* Smooth transitions */
}

.custom-alert h4 {
    font-size: 1.25rem;   /* Larger heading size */
    font-weight: bold;    /* Bold heading */
    margin-bottom: 10px;  /* Space below heading */
}

.alert-danger {
    background-color: #f8d7da !important; /* Lighter red */
    border-color: #f5c6cb !important;    /* Matching border */
    color: #721c24 !important;           /* Text color */
}

.alert-success {
    background-color: #d4edda !important; /* Lighter green */
    border-color: #c3e6cb !important;    /* Matching border */
    color: #155724 !important;           /* Text color */
}

.custom-alert:hover {
    transform: scale(1.02); /* Slight zoom effect on hover */
}

</style>
@endsection
@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-between" role="alert" id="error-alert">
    <span>
        <i class="icon fa fa-exclamation-triangle mr-2"></i>
        {{ Session::get('error') }}
    </span>
    <button type="button" class="close ml-3" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (Session::has('success'))
<div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-between" role="alert" id="success-alert">
    <span>
        <i class="icon fa fa-check mr-2"></i>
        {{ Session::get('success') }}
    </span>
    <button type="button" class="close ml-3" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif


@section('customJs')
    <script>
        // Automatically hide alerts after 5 seconds (5000 milliseconds)
setTimeout(() => {
    const errorAlert = document.getElementById('error-alert');
    const successAlert = document.getElementById('success-alert');

    if (errorAlert) {
        errorAlert.classList.remove('show'); // Hide the alert
        errorAlert.classList.add('fade');   // Add fade transition
        setTimeout(() => errorAlert.remove(), 500); // Remove from DOM after fade
    }

    if (successAlert) {
        successAlert.classList.remove('show');
        successAlert.classList.add('fade');
        setTimeout(() => successAlert.remove(), 500);
    }
}, 5000);

    </script>
@endsection



