import 'package:flutter/material.dart';

class ListMotivasi extends StatelessWidget {
  const ListMotivasi({Key? key, required this.isi}) :super(key:key);
  
  final String isi; 
  //final String tgl;

  @override
  Widget build(BuildContext context) {
    return Card(
      child: ListTile(
        title: Text(isi.toString(), style: const TextStyle(fontSize: 18.0),),
      ),
    );
  }
}