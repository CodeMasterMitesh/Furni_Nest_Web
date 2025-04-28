<?php include('../partition/header.php'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabulator/6.3.1/css/tabulator_midnight.min.css" integrity="sha512-MF7jJIBbOdfKGCR1UJe6mJJoj0/GYzdvAB3kpPAbo+bEQJFd/ueE7QPGBeuc77FTgV2Nob9AT4FHUf9Po3MfBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  :root {
    --primary-color: #4361ee;
    --secondary-color: #3f37c9;
    --accent-color: #4895ef;
    --dark-color: #1a1a2e;
    --light-color: #f8f9fa;
    --success-color: #4cc9f0;
    --danger-color: #f72585;
    --warning-color: #f8961e;
  }
  
  body {
    background-color: #f5f7fb;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  
  .card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
  }
  
  .card-header {
    background-color: white;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding: 1.25rem 1.5rem;
  }
  
  .tabulator {
    background-color: white;
    border-radius: 0 0 12px 12px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  
  .tabulator .tabulator-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    font-weight: 600;
    color: #495057;
  }
  
  .tabulator-row {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f0f0f0;
  }
  
  .tabulator-row:hover {
    background-color: #f8f9fa !important;
  }
  
  .tabulator-row.tabulator-row-even {
    background-color: #fcfcfc;
  }
  
  .tabulator-page.active {
    background-color: var(--primary-color) !important;
    color: white !important;
    border-color: var(--primary-color) !important;
  }
  
  .filter-section {
    background: white;
    padding: 1.25rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
  }
  
  .btn-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    padding: 0;
    border-radius: 8px;
  }
  
  .btn-sm {
    border-radius: 8px;
    padding: 0.35rem 0.75rem;
  }
  
  .action-btn {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    margin: 0 2px;
    transition: all 0.2s;
  }
  
  .action-btn:hover {
    transform: translateY(-2px);
  }
  
  .view-btn {
    background-color: rgba(67, 97, 238, 0.1);
    color: var(--primary-color);
  }
  
  .edit-btn {
    background-color: rgba(248, 150, 30, 0.1);
    color: var(--warning-color);
  }
  
  .delete-btn {
    background-color: rgba(247, 37, 133, 0.1);
    color: var(--danger-color);
  }
  
  .badge-status {
    padding: 0.35em 0.65em;
    border-radius: 50px;
    font-size: 0.75em;
    font-weight: 600;
  }
  
  .badge-active {
    background-color: rgba(76, 201, 240, 0.1);
    color: var(--success-color);
  }
  
  .badge-inactive {
    background-color: rgba(247, 37, 133, 0.1);
    color: var(--danger-color);
  }
  
  .search-box {
    position: relative;
  }
  
  .search-box .form-control {
    padding-left: 2.5rem;
    border-radius: 8px;
    border: 1px solid #e9ecef;
  }
  
  .search-box .search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #adb5bd;
  }
  
  /* Modern scrollbar */
  ::-webkit-scrollbar {
    width: 8px;
    height: 8px;
  }
  
  ::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
  }
  
  ::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
  }
  
  ::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
  }
  
  /* Floating action button */
  .fab {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background-color: var(--primary-color);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 20px rgba(67, 97, 238, 0.3);
    z-index: 1000;
    transition: all 0.3s;
  }
  
  .fab:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 24px rgba(67, 97, 238, 0.4);
    color: white;
  }
</style>

<div class="wrapper d-flex flex-column min-vh-100">
  <main class="flex-grow-1 py-4">
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h2 class="h4 mb-0" style="font-weight: 600; color: var(--dark-color);">Company Management</h2>
              <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb" style="font-size: 0.875rem; background-color: transparent; padding: 0;">
                  <li class="breadcrumb-item"><a href="#" style="color: var(--primary-color);">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page" style="color: #6c757d;">Companies</li>
                </ol>
              </nav>
            </div>
            <div>
              <button id="toggle-columns" class="btn btn-outline-secondary btn-sm me-2">
                <i class="mdi mdi-table-column me-1"></i> Columns
              </button>
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="mdi mdi-download me-1"></i> Export
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="#" id="download-xlsx"><i class="mdi mdi-file-excel me-2"></i> Excel</a></li>
                  <li><a class="dropdown-item" href="#" id="download-pdf"><i class="mdi mdi-file-pdf me-2"></i> PDF</a></li>
                  <li><a class="dropdown-item" href="#" id="download-csv"><i class="mdi mdi-file-delimited me-2"></i> CSV</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#" id="print-table"><i class="mdi mdi-printer me-2"></i> Print</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Filter Section -->
      <div class="card mb-4">
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-3">
              <div class="search-box">
                <i class="mdi mdi-magnify search-icon"></i>
                <input type="text" id="quick-search" class="form-control form-control-sm" placeholder="Search companies...">
              </div>
            </div>
            <div class="col-md-2">
              <select id="status-filter" class="form-select form-select-sm">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
            <div class="col-md-3">
              <div class="input-group">
                <input type="date" id="date-from" class="form-control form-control-sm" placeholder="From">
                <span class="input-group-text" style="font-size: 0.875rem;">to</span>
                <input type="date" id="date-to" class="form-control form-control-sm" placeholder="To">
              </div>
            </div>
            <div class="col-md-2">
              <button id="reset-filters" class="btn btn-sm btn-outline-secondary w-100">
                <i class="mdi mdi-filter-remove me-1"></i> Reset
              </button>
            </div>
            <div class="col-md-2 text-end">
              <a href="add_company_form.php" class="btn btn-sm btn-primary w-100">
                <i class="mdi mdi-plus me-1"></i> Add Company
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Main Table -->
      <div class="card">
        <div id="companyTable" style="width: 100%; min-height: 600px;"></div>
      </div>
    </div>
    
    <!-- Floating Action Button -->
    <a href="add_company_form.php" class="fab">
      <i class="mdi mdi-plus" style="font-size: 1.5rem;"></i>
    </a>
  </main>
</div>

<!-- Column Selection Modal -->
<div class="modal fade" id="columnsModal" tabindex="-1" aria-labelledby="columnsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="columnsModalLabel">Visible Columns</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row" id="columnToggleContainer">
          <!-- Column checkboxes will be inserted here by JavaScript -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="apply-columns">Apply Changes</button>
      </div>
    </div>
  </div>
</div>

<?php include('../partition/footer.php'); ?>

<!-- JavaScript Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tabulator/6.3.1/js/tabulator.min.js" integrity="sha512-8+qwMD/110YLl5T2bPupMbPMXlARhei2mSxerb/0UWZuvcg4NjG7FdxzuuvDs2rBr/KCNqhyBDe8W3ykKB1dzA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // Initialize Tabulator with modern theme
  var table = new Tabulator("#companyTable", {
    ajaxURL: "ajax/fetch_company_data.php",
    ajaxConfig: "POST",
    layout: "fitColumns",
    responsiveLayout: "collapse",
    pagination: "local",
    paginationSize: 20,
    paginationSizeSelector: [10, 20, 50, 100],
    movableColumns: true,
    initialSort: [{column: "id", dir: "desc"}],
    columnDefaults: {
      resizable: true,
      headerSortStartingDir: "asc",
      headerFilterPlaceholder: "Filter...",
    },
    columns: [
      { 
        title: "ID", 
        field: "id", 
        width: 80,
        hozAlign: "center",
        headerFilter: "input",
        frozen: true
      },
      { 
        title: "COMPANY NAME", 
        field: "company_name", 
        headerFilter: "input",
        cellClick: function(e, cell) {
          window.location.href = `view_company.php?id=${cell.getRow().getData().id}`;
        }
      },
      { 
        title: "ADDRESS", 
        field: "address_line", 
        headerFilter: "input",
        width: 200
      },
      { 
        title: "STATUS", 
        field: "status", 
        width: 120,
        hozAlign: "center",
        headerFilter: "select",
        headerFilterParams: {"": "All", "active": "Active", "inactive": "Inactive"},
        formatter: function(cell) {
          const status = cell.getValue();
          return `<span class="badge-status badge-${status}">${status.charAt(0).toUpperCase() + status.slice(1)}</span>`;
        }
      },
      { 
        title: "CREATED DATE", 
        field: "created_at", 
        width: 150,
        hozAlign: "center",
        formatter: "datetime",
        formatterParams: {
          inputFormat: "YYYY-MM-DD HH:mm:ss",
          outputFormat: "DD MMM YYYY",
          invalidPlaceholder: "-"
        }
      },
      {
        title: "ACTIONS",
        field: "actions",
        width: 150,
        hozAlign: "center",
        headerSort: false,
        frozen: true,
        formatter: function(cell) {
          const id = cell.getRow().getData().id;
          return `
            <div class="d-flex justify-content-center">
              <a href='view_company.php?id=${id}' class='action-btn view-btn' title="View">
                <i class="mdi mdi-eye"></i>
              </a>
              <a href='edit_company_form.php?id=${id}' class='action-btn edit-btn' title="Edit">
                <i class="mdi mdi-pencil"></i>
              </a>
              <button onclick='deleteCompany(${id})' class='action-btn delete-btn' title="Delete">
                <i class="mdi mdi-delete"></i>
              </button>
            </div>
          `;
        }
      }
    ],
    rowFormatter: function(row) {
      const data = row.getData();
      if(data.status === "inactive") {
        row.getElement().style.opacity = "0.8";
      }
    }
  });

  // Setup quick search
  document.getElementById("quick-search").addEventListener("input", function(e) {
    table.setFilter([
      [
        {field: "company_name", type: "like", value: e.target.value},
        {field: "address_line", type: "like", value: e.target.value}
      ]
    ]);
  });

  // Status filter
  document.getElementById("status-filter").addEventListener("change", function(e) {
    if(e.target.value) {
      table.setFilter("status", "=", e.target.value);
    } else {
      table.clearFilter();
    }
  });

  // Date range filter
  document.getElementById("date-from").addEventListener("change", function(e) {
    const dateTo = document.getElementById("date-to").value;
    if(e.target.value && dateTo) {
      table.setFilter([
        {field: "created_at", type: ">=", value: e.target.value},
        {field: "created_at", type: "<=", value: dateTo}
      ]);
    }
  });

  document.getElementById("date-to").addEventListener("change", function(e) {
    const dateFrom = document.getElementById("date-from").value;
    if(e.target.value && dateFrom) {
      table.setFilter([
        {field: "created_at", type: ">=", value: dateFrom},
        {field: "created_at", type: "<=", value: e.target.value}
      ]);
    }
  });

  // Reset all filters
  document.getElementById("reset-filters").addEventListener("click", function() {
    table.clearFilter();
    document.getElementById("quick-search").value = "";
    document.getElementById("status-filter").value = "";
    document.getElementById("date-from").value = "";
    document.getElementById("date-to").value = "";
  });

  // Export functions
  document.getElementById("download-xlsx").addEventListener("click", function(e) {
    e.preventDefault();
    table.download("xlsx", "companies.xlsx", {
      sheetName: "Companies",
      documentProcessing: function(workbook) {
        return workbook;
      }
    });
  });

  document.getElementById("download-pdf").addEventListener("click", function(e) {
    e.preventDefault();
    table.download("pdf", "companies.pdf", {
      orientation: "portrait",
      title: "Company List",
      autoTable: {
        styles: { fillColor: [67, 97, 238], textColor: 255 },
        headStyles: { fillColor: [47, 77, 218] }
      }
    });
  });

  document.getElementById("download-csv").addEventListener("click", function(e) {
    e.preventDefault();
    table.download("csv", "companies.csv");
  });

  document.getElementById("print-table").addEventListener("click", function(e) {
    e.preventDefault();
    table.print(false, true, {
      title: "Company List",
      format: true
    });
  });

  // Column toggle functionality
  document.getElementById("toggle-columns").addEventListener("click", function() {
    const columns = table.getColumnDefinitions();
    const container = document.getElementById("columnToggleContainer");
    container.innerHTML = "";
    
    columns.forEach(function(column) {
      if(column.field !== "actions") {
        const colDiv = document.createElement("div");
        colDiv.className = "col-md-6 mb-2";
        
        const formCheck = document.createElement("div");
        formCheck.className = "form-check";
        
        const input = document.createElement("input");
        input.className = "form-check-input";
        input.type = "checkbox";
        input.id = `col-${column.field}`;
        input.checked = column.visible !== false;
        
        const label = document.createElement("label");
        label.className = "form-check-label";
        label.htmlFor = `col-${column.field}`;
        label.textContent = column.title;
        
        formCheck.appendChild(input);
        formCheck.appendChild(label);
        colDiv.appendChild(formCheck);
        container.appendChild(colDiv);
      }
    });
  });

  document.getElementById("apply-columns").addEventListener("click", function() {
    const columns = table.getColumnDefinitions();
    const checkboxes = document.querySelectorAll("#columnToggleContainer input");
    
    checkboxes.forEach(checkbox => {
      const field = checkbox.id.replace("col-", "");
      const column = columns.find(col => col.field === field);
      if(column) column.visible = checkbox.checked;
    });
    
    table.setColumns(columns);
    bootstrap.Modal.getInstance(document.getElementById('columnsModal')).hide();
  });

  // Delete function with sweetalert2 confirmation
  function deleteCompany(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#4361ee',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        fetch(`delete_company.php?id=${id}`, { 
          method: "DELETE",
          headers: { 'Content-Type': 'application/json' }
        })
        .then(response => response.json())
        .then(result => {
          if(result.success) {
            Swal.fire(
              'Deleted!',
              'The company has been deleted.',
              'success'
            );
            table.replaceData();
          } else {
            Swal.fire(
              'Error!',
              result.message || 'Failed to delete company.',
              'error'
            );
          }
        })
        .catch(error => {
          console.error("Delete Error:", error);
          Swal.fire(
            'Error!',
            'An error occurred while deleting.',
            'error'
          );
        });
      }
    });
  }

  // Keyboard shortcuts
  document.addEventListener('keydown', function(e) {
    if(e.ctrlKey && e.key === 'f') {
      e.preventDefault();
      document.getElementById('quick-search').focus();
    }
    if(e.ctrlKey && e.key === 'r') {
      e.preventDefault();
      document.getElementById('reset-filters').click();
    }
  });
</script>