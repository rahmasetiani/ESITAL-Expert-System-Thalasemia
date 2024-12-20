<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Hasil Diagnosa dan Similarity</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="update_hasil.php">
        <div class="modal-body">
          <input type="hidden" name="idhasil" id="editIdHasil">
          
          <!-- Input untuk Hasil Diagnosa -->
          <div class="mb-3">
            <label for="editDiagnosa" class="form-label">Hasil Diagnosa</label>
            <textarea class="form-control" name="hasil_diagnosa" id="editDiagnosa" rows="3"></textarea>
          </div>

          <!-- Input untuk Hasil Similarity -->
          <div class="mb-3">
            <label for="editSimilarity" class="form-label">Hasil Similarity</label>
            <input type="number" class="form-control" name="hasil_similarity" id="editSimilarity" step="0.01">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
