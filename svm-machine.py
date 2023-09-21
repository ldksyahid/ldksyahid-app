import mysql.connector
import pandas as pd
from sklearn.preprocessing import StandardScaler
from sklearn.cluster import KMeans
from sklearn.svm import SVC
from sklearn.model_selection import train_test_split
from sklearn.metrics import confusion_matrix
import json
import matplotlib.pyplot as plt
from collections import Counter

# Koneksi ke database
conn = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="ldksyahid_db"
)

# Query data donasi yang sudah dibayar
query = "SELECT * FROM ldksyahid_db.donations a WHERE a.payment_status = 'PAID'"
cursor = conn.cursor()
cursor.execute(query)
data = cursor.fetchall()
cursor.close()

# Query data metode pembayaran
payment_query = "SELECT metode_pembayaran FROM ldksyahid_db.donations WHERE payment_status = 'PAID'"
cursor_payment = conn.cursor()
cursor_payment.execute(payment_query)
payment_data = cursor_payment.fetchall()
cursor_payment.close()
conn.close()


# Definisikan kolom-kolom yang akan digunakan
columns = ['id', 'jumlah_donasi', 'nama_donatur', 'email_donatur', 'usia', 'domisili', 'pekerjaan', 'no_telp_donatur', 'pesan_donatur', 'captcha', 'metode_pembayaran', 'nama_merchant', 'biaya_admin', 'kode_unik', 'campaign_id', 'doc_no', 'payment_status', 'payment_link', 'total_tagihan', 'created_at', 'updated_at']

# Buat DataFrame dari data
dataset = pd.DataFrame(data, columns=columns)

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

# Hitung matriks kebingungan
cm = confusion_matrix(y_test, y_pred, labels=svm_model.classes_)
class_frequencies = cm.diagonal()[::-1].tolist()

# Calculate the frequency of each donation class
class_counts = dataset['donation_class'].value_counts().sort_index()

class_labels = ['Class 0', 'Class 1', 'Class 2', 'Class 3', 'Class 4']


# Mengambil metode pembayaran dari hasil query
payment_methods = [row[0] for row in payment_data]

# Menghitung frekuensi metode pembayaran
payment_method_counts = Counter(payment_methods)

with open('public/svm-machine-output/confusion_matrix.json', 'w') as f:
    json.dump( cm.tolist(), f)

print("Confusion matrix has been calculated and saved to JSON file.")

# Create a dictionary to store bar plot data
bar_plot_data = {
    'class_labels': class_labels,
    'class_counts': class_frequencies
}


# Save bar plot data to JSON file
with open('public/svm-machine-output/bar_plot_data.json', 'w') as f:
    json.dump(bar_plot_data, f)

print("Bar plot data has been saved to JSON file.")

# Generate scatter plot data
scatter_data = {
    'x': X_test[:, 0].tolist(),
    'y': X_test[:, 1].tolist(),
    'predicted_class': y_pred.tolist()
}

# Save scatter plot data to JSON file
with open('public/svm-machine-output/scatter_data.json', 'w') as f:
    json.dump(scatter_data, f)

print("Scatter plot data has been calculated and saved to JSON file.")

# Save payment method data to JSON file
payment_method_data = {
    'payment_methods': list(payment_method_counts.keys()),
    'payment_counts': list(payment_method_counts.values())
}

with open('public/svm-machine-output/payment_method_data.json', 'w') as f:
    json.dump(payment_method_data, f)

print("Payment method data has been saved to JSON file.")
