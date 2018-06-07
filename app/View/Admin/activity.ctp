<?php //echo json_encode($activity); ?>

<div class="admin-header activity">
    <h1>User Activity</h1>
    <div class="admin-sort-search">
        <div class="drop sort-by">
            <p class="sort-by">SORT BY</p>
            <span class="chevron sort-by"></span>
			<div class="sort-by-menu activity">
				<p class="username cat">Username</p>
				<p class="date cat active">Date</p>
				<p class="type cat">Type</p>
				<p class="ascending active">Ascending</p>
				<p class="descending">Descending</p>
			</div>
        </div>
        <div class="drop filter-by">
            <p class="filter-by">ALL ACTIVITY</p>
            <span class="chevron filter-by"></span>
            <div class="filter-menu">
                <p class="logins">Logins</p>
                <p class="new-annotation">New Annotations</p>
                <p class="new-flag">New Flags</p>
                <p class="edited-metadata">Metadata Edits</p>
                <p class="all-activity active">All Activity</p>
            </div>
        </div>
        <input class="admin-search activity" type="text" placeholder="Search for a user here">
    </div>
</div>

<div id="admin-flags">
    <div id="activity"></div>
</div>
<script type="text/javascript">
	arcs.adminView = new arcs.views.admin.Activity({
        el: $('#admin-flags'),
        collection: new arcs.collections.FlagList(<?php echo json_encode($activity) ?>)
    });
</script>