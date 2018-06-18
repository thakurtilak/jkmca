

            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                            <th>Currency</th>
                            <th>Rate</th>
                        </thead>
                        <tbody>
                        <?php if(isset($responseArray) && $responseArray): ?>
                        <?php foreach($responseArray as $key => $value): ?>
                            <tr>
                                <td><?php echo $key; ?></td>
                                <td><?php echo $value; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <div class="row">
            Unable to get currency rates
        </div>
    <?php endif; ?>
