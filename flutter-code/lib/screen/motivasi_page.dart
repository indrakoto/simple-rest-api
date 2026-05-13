import 'dart:convert';
//import 'dart:io';
import 'package:http/http.dart' as http;
import 'package:flutter/material.dart';
import 'package:vigenesia/models/motivasi.dart';
import 'package:vigenesia/ui/listmotivasi_page.dart';

class MotivasiPage extends StatefulWidget {
  const MotivasiPage({super.key});


  @override
  // ignore: library_private_types_in_public_api
  _MotivasiPageState createState() => _MotivasiPageState();

}

class _MotivasiPageState extends State<MotivasiPage> {
  List<Motivasi> listMotivasi = [];

  getListMotivasi() async {
    try {
      
      var client = http.Client();

      var response = await client.get(
        Uri.http('vigenesia.site','/api/motivasi'),
        headers: {},
      );

      if(response.statusCode == 200) {
        final dataSource = jsonDecode(response.body);
        //debugPrint(dataSource);
        setState(() {
          for (var i = 0; i < dataSource.length; i++) {
            listMotivasi.add(Motivasi.fromJson(dataSource[i]));
          }
        });
      }
    } catch (e) {
      debugPrint('$e');
    }
  }

  @override
  void initState() {
    getListMotivasi();
    super.initState;
  }

  Widget buildListItem(index) {

    var item = listMotivasi[index];

    return ListMotivasi(
      isi: item.isiMotivasi.toString(),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('List Motivasi')),
      body: ListView.builder(
        itemCount: listMotivasi.length,
        itemBuilder: (BuildContext context, int index) {
          return buildListItem(index);
        }, 
      ),
    );
  }

}
