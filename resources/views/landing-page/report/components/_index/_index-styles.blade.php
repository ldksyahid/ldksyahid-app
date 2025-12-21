<style>
    /* Card Styling */
    .report-card {
        border-radius: 15px;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.1);
        background: white;
        box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
        height: 515px; /* Fixed height like template */
    }

    .report-card .card-body {
        padding: 20px;
    }

    .report-card .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        min-height: 2.5rem;
    }

    .report-card .card-text {
        font-size: 0.9rem;
        color: #6c757d;
        overflow: hidden;
    }

    .report-card .card-img-top {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        transition: transform 0.5s ease;
    }

    .report-card:hover .card-img-top {
        transform: scale(1.05);
    }

    /* Button Styling */
    .btn-primary {
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
    }


    /* Responsive */
    @media (max-width: 768px) {
        .report-card {
            margin-bottom: 20px;
            height: auto;
            min-height: 450px;
        }
    }

    /* Card image container */
    .position-relative {
        height: 200px;
        overflow: hidden;
    }

    .object-fit-cover {
        object-fit: cover;
    }
</style>
