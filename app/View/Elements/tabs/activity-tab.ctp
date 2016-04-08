<div class="tab-pane" id="activity-tab">        		
<?php if(empty($user_info['Activity'])): ?>
    <h3>This user has no activity</h3>
<?php else: ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Type</th>
                <th>For</th>
                <th>Content <i class="icon icon-question-sign" rel="tooltip" title="This will either be a link to another resource, a transcription of a section of a resource, or a link to a page outside ARCS "</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody><?php foreach($user_info['Activity'] as $a): ?>
              <tr>
                  <td>
                  <!-- TO DO: ADD THE CODE FOR DISPLAYING WHAT AN ACTIVITY CORRESPONDS TO -->
                    <i class="<?php if(isset($a['relation']))
                                      echo 'icon-retweet" rel="tooltip" title="Relation';
                                    else if(isset($a['transcript']))
                                      echo 'icon-align-left" rel="tooltip" title="Transcript';
                                    else if(isset($a['url']))
                                      echo 'icon-share" rel="tooltip" title="Outside URL';
                                    else
                                      echo 'icon-question-sign" rel="tooltip" title="Type Unknown" target="_blank';
                              ?>"></i>
                  </td>
                  
                  <td><?php echo $this->Html->link($a['resource_id'], 
                      '/resource/' . $a['resource_id']); ?></td>
                  <td>
                    <?php if(isset($a['relation'])) : ?>
                          <?php echo $this->Html->link($a['relation'], 
                      '/resource/' . $a['relation']); ?>
                           
                    <?php elseif(isset($a['transcript'])) : ?>
                        
                            <p><?php echo $a['transcript']; ?></p>
                            
                        <?php elseif(isset($a['url'])) : ?>
                        
                          <a href="<?php echo $a['url']; ?>"
                            ><?php echo $a['url']; ?></a>
                           
                    <?php endif; ?>
                    
                  </td>
                  
                  <!-- date --><td><?php echo $a['created']; ?></td>
              </tr>
          <?php endforeach; ?></tbody>
    </table>
<?php endif ?>
</div><!-- #activity-tab -->