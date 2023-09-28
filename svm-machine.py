import mysql.connector
import pandas as pd
from sklearn.preprocessing import StandardScaler
from sklearn.svm import SVC
from sklearn.model_selection import train_test_split
from sklearn.metrics import confusion_matrix
import json
from collections import Counter
from sklearn.metrics import accuracy_score
from sklearn.metrics import classification_report

# Koneksi ke database
config = {
    "host": "127.0.0.1",
    "user": "root",
    "password": "",
    "database": "ldksyahid_db"
}
conn = mysql.connector.connect(**config)

# Query dataset donasi yang sudah dibayar
query_dataset = "SELECT * FROM ldksyahid_db.ms_donationdataset a WHERE a.payment_status = 'PAID'"
cursor = conn.cursor()
cursor.execute(query_dataset)
fetch_dataset = cursor.fetchall()
cursor.close()

# Definisikan kolom-kolom yang akan digunakan
columns = ['id', 'jumlah_donasi', 'nama_donatur', 'email_donatur', 'usia', 'domisili', 'pekerjaan', 'no_telp_donatur', 'pesan_donatur', 'captcha', 'metode_pembayaran', 'nama_merchant', 'biaya_admin', 'kode_unik', 'campaign_id', 'doc_no', 'payment_status', 'payment_link', 'total_tagihan', 'created_at', 'updated_at', 'idInc']

# Buat DataFrame dari data
dataset = pd.DataFrame(fetch_dataset, columns=columns)

# Buat fungsi untuk mengklasifikasikan jumlah donasi ke dalam kelas
def classify_donation(donation_amount):
    if donation_amount <= 25000:
        return 0
    elif donation_amount <= 50000:
        return 1
    elif donation_amount <= 100000:
        return 2
    elif donation_amount <= 250000:
        return 3
    else:
        return 4

# Tambahkan kolom klasifikasi berdasarkan jumlah donasi
dataset['donation_class'] = dataset['jumlah_donasi'].astype(int).apply(classify_donation)

# Pilih fitur untuk klasifikasi
classification_features = dataset[['usia', 'donation_class']]

# Standarisasi fitur-fitur
scaler = StandardScaler()
scaled_features = scaler.fit_transform(classification_features)

# Pilih label klasifikasi
classification_labels = (dataset['donation_class']).astype(int)

# Bagi dataset menjadi data latih dan data uji jika ada lebih dari satu baris data
X_train, X_test, y_train, y_test = train_test_split(scaled_features, classification_labels, test_size=0.2, random_state=0)

# Inisialisasi model SVM
svm_model = SVC(kernel='linear')

# Latih model SVM
svm_model.fit(X_train, y_train)

# Lakukan prediksi menggunakan data uji
y_pred = svm_model.predict(X_test)

# Hitung akurasi
# accuracy = accuracy_score(y_test, y_pred) * 100
# print(f"SVM Accuracy: {accuracy:.2f}%")

 # Classification report
print("\nClassification Report:")
print(classification_report(y_test, y_pred))

# Hitung matriks kebingungan
cm = confusion_matrix(y_test, y_pred, labels=svm_model.classes_)

with open('public/svm-machine-output/confusion_matrix.json', 'w') as f:
    json.dump(cm.tolist(), f)

print("Confusion matrix has been calculated and saved to JSON file.")

# Ambil data dari hasil query
query_donations = "SELECT * FROM ldksyahid_db.donations a WHERE a.payment_status = 'PAID'"
cursor = conn.cursor()
cursor.execute(query_donations)
fetch_donations = cursor.fetchall()
cursor.close()

# Buat DataFrame dari data baru
new_data_columns = ['id', 'jumlah_donasi', 'nama_donatur', 'email_donatur', 'usia', 'domisili', 'pekerjaan', 'no_telp_donatur', 'pesan_donatur', 'captcha', 'metode_pembayaran', 'nama_merchant', 'biaya_admin', 'kode_unik', 'campaign_id', 'doc_no', 'payment_status', 'payment_link', 'total_tagihan', 'created_at', 'updated_at', 'idInc']
new_data_df = pd.DataFrame(fetch_donations, columns=new_data_columns)

# Inisialisasi list untuk menyimpan hasil prediksi
predicted_classes = []

for _, new_data_row in new_data_df.iterrows():
    new_usia = new_data_row['usia']
    new_jumlah_donasi = int(new_data_row['jumlah_donasi'])  # Convert to integer

    # Tambahkan kolom klasifikasi berdasarkan jumlah donasi
    new_donation_class = classify_donation(new_jumlah_donasi)

    # Buat new_data dengan format yang sesuai
    new_data = [[new_usia, new_donation_class]]

    # Standarisasi data baru menggunakan scaler yang sudah ada
    scaled_new_data = scaler.transform(new_data)

    # Lakukan prediksi
    predicted_class = svm_model.predict(scaled_new_data)

    # Simpan kelas prediksi ke dalam list
    predicted_classes.append(predicted_class[0])

class_labels = ['Class 0', 'Class 1', 'Class 2', 'Class 3', 'Class 4']
class_counts = [predicted_classes.count(i) for i in range(len(class_labels))]

# Create a dictionary to store bar plot data
bar_plot_data = {
    'class_labels': class_labels,
    'class_counts': class_counts
}

# Save bar plot data to JSON file
with open('public/svm-machine-output/bar_plot_data.json', 'w') as f:
    json.dump(bar_plot_data, f)

print("Bar plot data has been saved to JSON file.")
