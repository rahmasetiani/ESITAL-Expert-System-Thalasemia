<?php
// Koneksi ke database
include '../../database/koneksi.php'; // Ganti dengan file koneksi Anda

// Ambil data JSON dari request
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['idhasil'], $data['hasil_diagnosa'], $data['hasil_similarity'])) {
    $idhasil = $data['idhasil'];
    $hasil_diagnosa = $data['hasil_diagnosa'];
    $hasil_similarity = $data['hasil_similarity'];

    // Query untuk mengupdate data
    $query = "UPDATE hasil 
              SET hasil_diagnosa = ?, hasil_similarity = ?, status_revisi = 'accepted'
              WHERE idhasil = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $hasil_diagnosa, $hasil_similarity, $idhasil);

    if ($stmt->execute()) {
        echo json_encode(value: ['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }


    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']);
}
