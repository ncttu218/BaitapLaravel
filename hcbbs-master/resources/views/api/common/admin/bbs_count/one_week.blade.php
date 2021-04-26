<html>
    <body>
        <table border="1">
            <tr>
                <th>日付</th>
                <?php
                $date = $beginningDate;
                ?>
                @while ($date <= $endingDate)
                    <td>{{ date('Y/m/d', $date) }}</td>
                    <?php
                    $date = $DateUtil::calculateTime(1, $date);
                    ?>
                @endwhile
                <th>合計</th>
            </tr>
            @foreach ($baseList as $baseCode => $baseName)
            <tr>
                <th>{{ $baseName }}</th>
                    <?php
                    $date = $beginningDate;
                    ?>
                    @while ($date <= $endingDate)
                        <?php
                        $timeKey = date('Y-m-d', $date);
                        ?>
                        <td>{{ isset($counterData['daily'][$baseCode]) ? $counterData['daily'][$baseCode][$timeKey] ?? 0 : 0 }}</td>
                        <?php
                        $date = $DateUtil::calculateTime(1, $date);
                        ?>
                    @endwhile
                <th>{{ $counterData['totalByBase'][$baseCode] ?? 0 }}</th>
            </tr>
            @endforeach
        </table>
    </body>
</html>
