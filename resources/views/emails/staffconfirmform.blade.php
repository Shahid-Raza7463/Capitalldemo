<style>
    .btn {
        font-size: 14px;
        border-radius: 2px;
        border: 1px solid transparent;
        padding: .375rem .75rem;
    }

    .btn-success {
        color: #fff;
        background-color: #28a745;
        border-color: #28a745;
        box-shadow: 0 2px 6px 0 rgb(40 167 69 / 50%);
    }

    .btnn {
        font-size: 14px;
        border-radius: 2px;
        border: 1px solid transparent;
        padding: .375rem .75rem;
    }

    .btnn-danger {
        color: #fff;
        background-color: #f82436;
        border-color: #f82436;
        box-shadow: 0 2px 6px 0 rgb(40 167 69 / 50%);
    }

</style>
<h3>you have a new staff approvel request</h3>

<h3 class="fs-23 font-weight-600 mb-2">
    Dear sir/madam,
    <br><br>
</h3>
<p>
    Are you applicable for work ?
</p>

<a target="blank"
    href="{{url('/teamconfirm?'.'assignmentmappingid='.$assignmentmappingid.'&&'.'teammemberid='.$teamid.'&&'.'status='.$yes)}}"
    class="btn btn-success">
    Yes
</a>

<a target="blank"
    href="{{url('/teamconfirm?'.'assignmentmappingid='.$assignmentmappingid.'&&'.'teammemberid='.$teamid.'&&'.'status='.$no)}}"
    class="btnn btnn-danger">
    No
</a>
