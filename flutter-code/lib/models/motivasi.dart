class Motivasi {
  String? id;
  String? isiMotivasi;
  String? idUser;
  String? tglInput;

  Motivasi({
    this.id, 
    this.isiMotivasi, 
    this.idUser, 
    this.tglInput
  });

  Motivasi.fromJson(Map<String, dynamic> json) : 
    id = json['id'],
    isiMotivasi = json['isi_motivasi'],
    idUser = json['iduser'],
    tglInput = json['tanggal_input'];
}