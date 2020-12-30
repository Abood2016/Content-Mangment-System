<div class="card-body">
    <form action="{{ route('admin.contact_us.index') }}" method="GET">
        <div class="row">
            <div class="col-2">
                <label for="status">Key</label>
                <div class="form-group">
                    <input type="text" name="keyword" class="form-control"
                        value="{{ old('keyword',request()->input('keyword'))}}" placeholder="Filter">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option disabled selected>status</option>
                        <option value="1" {{old('status',request()->input('status') == '1') ? 'selected' : ''}}>
                            Read
                        </option>
                        <option value="0" {{old('status',request()->input('status') == '0') ? 'selected' : ''}}>
                            New
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="status">Sort By</label>
                    <select name="sort_by" id="sort_by" class="form-control">
                        <option disabled selected>Sort By</option>
                        <option value="id" {{old('sort_by',request()->input('sort_by') == 'id') ? 'selected' : ''}}>Id</option>
                        <option value="name"{{old('sort_by',request()->input('sort_by') == 'name') ? 'selected' : ''}}>Name</option>
                        <option value="title" {{old('sort_by',request()->input('sort_by') == 'title') ? 'selected' : ''}}>Title</option>
                        <option value="created_at" {{old('sort_by',request()->input('sort_by') == 'created_at') ? 'selected' : ''}}>Created Date</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="status">Order By</label>
                    <select name="order_by" id="order_by" class="form-control">
                        <option disabled selected>Order By</option>
                        <option value="asc" {{old('order_by',request()->input('order_by') == 'asc') ? 'selected' : ''}}>Ascending</option>
                        <option value="desc" {{old('order_by',request()->input('order_by') == 'desc') ? 'selected' : ''}}>Descending</option>
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="status">Limit By</label>
                    <select name="limit_by" id="limit_by" class="form-control">
                        <option disabled selected>Paginate By</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>

            <div class="col-1">
                <div class="form-group">
                    <label for="Filter">Filtering..</label>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
            
        </div>
    </form>
</div>