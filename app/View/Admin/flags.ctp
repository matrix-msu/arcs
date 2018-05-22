<?php
    //echo $this->element('admin_nav', array('active' => 'flags'));
?>

<div class="admin-header">
    <h1>Flags</h1>
    <div class="admin-sort-search">
        <div class="drop sort-by">
            <p class="sort-by">SORT BY</p>
            <span class="chevron sort-by"></span>
			<div class="sort-by-menu flags">
                <p class="date cat active">Date</p>
				<p class="object cat">Object Name</p>
				<p class="relation cat">Type</p>
				<p class="flagged-by cat">Flagged By</p>
				<p class="ascending active">Ascending</p>
				<p class="descending">Descending</p>
			</div>
        </div>
        <div class="drop filter-by">
            <p class="all-flags filter-by">ALL FLAGS</p>
            <span class="chevron filter-by"></span>
            <div class="filter-menu flags">
                <p class="pending">Pending</p>
                <p class="unresolved">Unresolved</p>
                <p class="resolved">Resolved</p>
                <p class="all-flags active">All Flags</p>
            </div>
        </div>
        <input class="admin-search flags" type="text" placeholder="Search for a user here">
    </div>
</div>


<div id="admin-flags">
    <div id="flags"></div>
</div>
<script type="text/javascript">
	arcs.adminView = new arcs.views.admin.Flags({
      	el: $('#admin-flags'),
      	collection: new arcs.collections.FlagList(<?php echo json_encode($flags) ?>)
    });
</script>
