<?php
$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $requiredFields = [
        "umalembranca",
        "citejunto",
        "verofabio",
        "curiosa",
        "Casaria"
    ];

    $formData = $_POST;

    foreach ($requiredFields as $field) {
        if ($field === "Casaria" && !isset($formData[$field])) {
            http_response_code(400);
            $response['error'] = 'Por favor, selecione se casaria ou não com o Fábio.';
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            exit();
        }

        if (!isset($formData[$field]) || empty($formData[$field])) {
            http_response_code(400);
            $response['error'] = 'Por favor, preencha todos os campos obrigatórios.';
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            exit();
        }
    }

    // Substitui os underscores por espaços nas chaves do array
    $formData = array_combine(
        array_map(function ($key) {
            return str_replace('_', ' ', $key);
        }, array_keys($formData)),
        $formData
    );

    if (!empty($formData)) {
        $filePath = 'dados.txt';

        // Adiciona espaços entre as respostas, remove vírgula extra e adiciona linha abaixo de cada resposta
        $formattedData = json_encode($formData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $formattedData = preg_replace_callback('/"([^"]+)": "(.*?)",\s*(?=})/', function ($match) {
            return sprintf('"%s": "%s",%s"%s"%s', $match[1], $match[2], PHP_EOL, str_repeat("_", strlen($match[1])), PHP_EOL);
        }, $formattedData);

        file_put_contents($filePath, $formattedData);
        $response['success'] = ' obrigado!!';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(400);
        $response['error'] = 'Por favor, selecione pelo menos uma opção antes de concluir.';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
} else {
    http_response_code(405);
    $response['error'] = 'Método não permitido.';
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
?>
