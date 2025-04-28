<?php include('../partition/header.php'); ?>
<div class="wrapper d-flex flex-column min-vh-100">
    <main class="flex-grow-1">
        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Company</h3>
                <a href="add_company_form.php" class="btn btn-primary">Add Company</a>
            </div>
            <div id="myGrid" class="ag-theme-alpine" style="height: 600px; width: 100%;"></div>
        </div>
    </main>
</div>

<!-- AG Grid JS + CSS -->
<link href="https://cdn.jsdelivr.net/npm/ag-grid-community/styles/ag-grid.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/ag-grid-community/styles/ag-theme-alpine.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.noStyle.js"></script>

<script>
    // Column Definitions
    const columnDefs = [
        { headerName: "ID", field: "id", filter: 'agNumberColumnFilter', sortable: true },
        { headerName: "Company Name", field: "company_name", filter: 'agTextColumnFilter', sortable: true },
        { headerName: "Address", field: "address_line", filter: 'agTextColumnFilter', sortable: true },
        {
            headerName: "Actions",
            cellRenderer: (params) => {
                const id = params.data.id;
                return `
                    <a href="edit_company_form.php?id=${id}" class="btn btn-sm btn-warning me-1">Edit</a>
                    <button onclick="deleteCompany(${id})" class="btn btn-sm btn-danger">Delete</button>
                `;
            }
        }
    ];

    // Grid Options
    const gridOptions = {
        columnDefs: columnDefs,
        defaultColDef: {
            filter: true,
            sortable: true,
            resizable: true
        },
        pagination: true,
        paginationPageSize: 10,
        rowSelection: 'single',
        animateRows: true
    };

    // Setup the grid
    const eGridDiv = document.getElementById('myGrid');
    agGrid.createGrid(eGridDiv, gridOptions);
    
    // Fetch data from PHP (Ajax)
    fetch('ajax/fetch_company_data.php')
        .then(response => response.json())
        .then(data => {
            gridOptions.api.setRowData(data);
        });

    // Delete Function
    function deleteCompany(id) {
        if (confirm('Are you sure you want to delete this company?')) {
            fetch('delete_company_form.php?id=' + id)
                .then(res => res.text())
                .then(res => {
                    alert('Company deleted');
                    location.reload(); // or refetch the grid data
                });
        }
    }
</script>

<?php include('../partition/footer.php'); ?>