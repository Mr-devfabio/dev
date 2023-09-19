<?php
$video1 = $_POST['video1'];
$video2 = $_POST['video2'];
$output = $_POST['output'];

$ffmpeg_command = "ffmpeg -i $video1 -i $video2 -filter_complex [0:v][1:v]concat=n=2:v=1:a=0[outv] -map [outv] -strict -2 $output";

exec($ffmpeg_command, $output, $return_code);

if ($return_code === 0) {
    echo json_encode(array('status' => 'success', 'output_path' => $output));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Falha ao mesclar vídeos.'));
}
?>
