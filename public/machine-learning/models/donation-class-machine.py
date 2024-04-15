import mysql.connector
import pandas as pd
from sklearn.preprocessing import StandardScaler
from sklearn.svm import SVC
from sklearn.model_selection import train_test_split
from sklearn.metrics import confusion_matrix
import json
from sklearn.metrics import accuracy_score
from sklearn.metrics import classification_report

######## AMBIL DATA QUERY UNTUK MEMBUAT MODEL ########
# Koneksi ke database
config = {
    "host": "127.0.0.1",
    "user": "root",
    "password": "",
    "database": "ldksyahid_db",
    "port": 3306  # Ganti dengan port yang sesuai
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

# Beri nama kolom pada dataframe classification_features
classification_features.columns = ['usia', 'donation_class']

# Standarisasi fitur-fitur
scaler = StandardScaler()
scaled_features = scaler.fit_transform(classification_features)

# Pilih label klasifikasi
classification_labels = (dataset['donation_class']).astype(int)

# Bagi dataset menjadi data latih dan data uji jika ada lebih dari satu baris data
X_train, X_test, y_train, y_test = train_test_split(scaled_features, classification_labels, test_size=0.2, random_state=0)

# Inisialisasi model SVM
svm_model = SVC(kernel='poly', C=10, gamma=1)

# Latih model SVM
svm_model.fit(X_train, y_train)

# Lakukan prediksi menggunakan data uji
y_pred = svm_model.predict(X_test)

# Hitung akurasi
accuracy = accuracy_score(y_test, y_pred) * 100
print(f"SVM Accuracy: {accuracy:.2f}%")


######## AMBIL DATA QUERY UNTUK PREDIKSI ########
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
with open('public/machine-learning/output/bar_plot_donation_class.json', 'w') as f:
    json.dump(bar_plot_data, f)

print("Bar plot donation class data has been saved to JSON file.")

# Konversi kolom 'usia' menjadi tipe data integer
new_data_df['usia'] = pd.to_numeric(new_data_df['usia'], errors='coerce')
new_data_df['jumlah_donasi'] = pd.to_numeric(new_data_df['jumlah_donasi'], errors='coerce')

# Buat fungsi untuk mengklasifikasikan usia menjadi kategori
def classify_age(age):
    if 5 <= age <= 11:
        return 'Children (5-11 years old)'
    elif 12 <= age <= 25:
        return 'Teenagers (12-25 years old)'
    elif 26 <= age <= 45:
        return 'Adults (26-45 years old)'
    elif 46 <= age <= 65:
        return 'Elderly (46-65 years old)'
    else:
        return 'Other Ages'

# Tambahkan kolom klasifikasi usia ke dalam dataset baru
new_data_df['age_category'] = new_data_df['usia'].apply(classify_age)

# Buat fungsi untuk mengklasifikasikan jumlah donasi menjadi kategori
def classify_donation(donation_amount):
    if donation_amount <= 25000:
        return 'Low (0 - 25k)'
    elif 26000 <= donation_amount <= 50000:
        return 'Moderately Low (26k - 50k)'
    elif 51000 <= donation_amount <= 100000:
        return 'Moderate (51k - 100k)'
    elif 101000 <= donation_amount <= 250000:
        return 'Moderately High (101k - 250k)'
    else:
        return 'High (> 251k)'

# Tambahkan kolom klasifikasi jumlah donasi ke dalam dataset baru
new_data_df['donation_category'] = new_data_df['jumlah_donasi'].apply(classify_donation)

# Mengelompokkan data berdasarkan kategori usia dan kategori donasi serta menghitung jumlah orang yang berdonasi
donation_count = new_data_df.groupby(['age_category', 'donation_category']).size().reset_index(name='donor_count')

# Simpan data bar plot ke dalam format JSON
bar_plot_json = {
    'age_category': donation_count['age_category'].tolist(),
    'donation_category': donation_count['donation_category'].tolist(),
    'donor_count': donation_count['donor_count'].tolist()
}

with open('public/machine-learning/output/bar_plot_count_age_donation.json', 'w') as json_file:
    json.dump(bar_plot_json, json_file)

print("Bar plot count age donation data has been saved to JSON file.")


# Hitung jumlah donatur berdasarkan kategori usia
age_category_counts = new_data_df['age_category'].value_counts()

# Konversi ke dictionary
age_category_dict = age_category_counts.to_dict()

# Simpan ke dalam file JSON
with open('public/machine-learning/output/pie_chart_age_category_counts.json', 'w') as file:
    json.dump(age_category_dict, file)

print("Pie chart age category counts data has been saved to JSON file.")
