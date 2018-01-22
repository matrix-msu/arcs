<?php //echo json_encode($metadata); ?>

<h1 class="admin-header">Metadata Edits</h1>

<div id="admin-flags">
    <div id="metadata_edits"></div>
</div>
<script type="text/javascript">
    arcs.adminView = new arcs.views.admin.Metadata_edits({
        el: $('#admin-flags'),
        collection: new arcs.collections.FlagList(<?php echo json_encode($metadata) ?>)
    });
</script>