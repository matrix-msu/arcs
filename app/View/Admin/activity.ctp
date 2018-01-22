<?php echo json_encode($activity); ?>

<h1 class="admin-header">Activity</h1>

<div id="admin-flags">
    <div id="activity"></div>
</div>
<script type="text/javascript">
    arcs.adminView = new arcs.views.admin.Activity({
        el: $('#admin-flags'),
        collection: new arcs.collections.FlagList(<?php echo json_encode($activity) ?>)
    });
</script>