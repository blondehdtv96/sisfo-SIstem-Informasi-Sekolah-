-- Add rombel column to tb_kelas table
ALTER TABLE tb_kelas ADD COLUMN rombel VARCHAR(5) AFTER id_jurusan;

-- Update existing records to extract rombel from nama_kelas
-- For example: "X RPL 1" -> rombel = "1", "XI TKJ A" -> rombel = "A"
UPDATE tb_kelas SET rombel = TRIM(SUBSTRING_INDEX(nama_kelas, ' ', -1));

-- Add index for better performance
CREATE INDEX idx_kelas_rombel ON tb_kelas(rombel);