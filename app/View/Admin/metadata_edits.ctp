<?php //echo json_encode($metadata); ?>

<div class="admin-header">
    <h1>Metadata Edits</h1>
    <div class="admin-sort-search">
        <input class="search admin-search meta searchForUser" placeholder='Search for a user'>
        <div class="drop sort-by">
            <p class="sort-by">SORT BY</p>
            <span class="chevron sort-by"></span>
			<div class="sort-by-menu meta">
                <p class="date cat active">DATE</p>
				<p class="resource-kid cat">RESOURCE KID</p>
				<p class="username cat">USERNAME</p>
				<p class="metadata-kid cat">METADATA KID</p>
				<p class="field-name cat">FIELD NAME</p>
				<p class="old-value cat">OLD VALUE</p>
				<p class="new-value cat">NEW VALUE</p>
                <p class="ascending active">Ascending</p>
				<p class="descending">Descending</p>
			</div>
        </div>
        <div class="drop filter-by">
            <p class="all-flags filter-by">ALL EDITS</p>
            <span class="chevron filter-by"></span>
            <div class="filter-menu meta">
                <p class="pending">Pending</p>
                <p class="approved">Approved</p>
                <p class="rejected">Rejected</p>
                <p class="all-edits active">All EDITS</p>
            </div>
        </div>
    </div>
</div>

<div id="admin-flags">
    <div id="metadata_edits"></div>
</div>
<script type="text/javascript">
    arcs.adminView = new arcs.views.admin.Metadata_edits({
        el: $('#admin-flags'),
        collection: new arcs.collections.FlagList(<?php echo json_encode($metadata) ?>)
    });
</script>

<div class="admin-pagination users">
	<div class="ipp">
    <div class="menu">
			<p class="curr">25 ITEMS PER PAGE</p>
			<p>50 ITEMS PER PAGE</p>
			<p>75 ITEMS PER PAGE</p>
			<p>DISPLAY ALL</p>
		</div>
	  <div class="drop">
		  <p class="per">25 ITEMS PER PAGE</p>
		  <span class="chevron"></span>
	  </div>
  </div>
  <div class="page-pick">
	  <div class='arrow-wrap left'><span class="chevron left"></span></div>
	  <div class="by-num"></div>
	  <div class='arrow-wrap right'><span class="chevron right"></span></div>
  </div>
</div>
