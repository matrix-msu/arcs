<div class="tab-pane" id="transcriptions-tab">
<?php if(empty($user_info['Transcription'])): ?>
    <h3>This user hasn't made any transcriptions yet</h3>
<?php else: ?>
    <table class="table table-striped">
        <tbody><?php foreach($user_info['Transcription'] as $t): ?>
              <tr>
                  <td>
                    <!-- PLACEHOLDER FOR THUMBNAIL -->
                  </td>
                  <td><?php echo $t['resource_name']; ?></td>
                  <td>Resource Type</td>
                  <td><?php echo date('M d, Y', strtotime($t['created'])); ?></td>
                  <td><?php echo "Transcription here" ?>
                  </td>
              </tr>
          <?php endforeach; ?></tbody>
    </table>
<?php endif ?>
</div>