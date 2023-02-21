// ignore_for_file: unnecessary_new

import 'package:flutter/material.dart';
import 'dart:developer' as developer;

import 'package:lelanginaja/ui/detail.dart';
import 'package:lelanginaja/ui/payment.dart';
import 'package:lelanginaja/widget/appbarlelangin.dart';
import 'package:lelanginaja/widget/bottombarlelangin.dart';
import 'package:lelanginaja/bloc/History_bloc.dart';
import 'package:lelanginaja/model/History.dart';
import 'package:http/http.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert';
import 'dart:developer' as developer;

List list = [
  "Flutter",
  "React",
  "Ionic",
  "Xamarin",
];

class Histories extends StatefulWidget {
  Histories({Key? key}) : super(key: key);

  @override
  State<Histories> createState() => _HistoriesState();
}

class _HistoriesState extends State<Histories> {
  void cancelBid(String id) async {
    SharedPreferences localStorage = await SharedPreferences.getInstance();
    var token = jsonDecode(localStorage.getString('token').toString());

    try {
      Response response = await post(
        Uri.parse(
            dotenv.env['API_URL'].toString() + "/api/cancel-bid?id=" + id),
        headers: {'Authorization': 'Bearer ' + token},
      );

      if (response.statusCode == 200) {
        setState(() {});
      } else {
        developer.log(response.statusCode.toString());
        showDialog(
            context: context,
            builder: (BuildContext context) {
              return AlertDialog(
                title: Text("Error"),
                content: Text('Error Terjadi'),
                actions: [
                  ElevatedButton(
                    child: const Text('Kembali'),
                    style: ElevatedButton.styleFrom(
                      minimumSize: const Size.fromHeight(50),
                      primary: Color(0xFF696cff), // background
                      onPrimary: Colors.white, // foreground
                    ),
                    onPressed: () {
                      Navigator.of(context).pop();
                    },
                  )
                ],
              );
            });
      }
    } catch (e) {
      developer.log(e.toString());
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      resizeToAvoidBottomInset: false,
      body: ListView(children: [
        Column(children: [
          Container(
            child: AppBarLelangin(),
          ),
          Container(
              margin: const EdgeInsets.all(10),
              child: Wrap(
                children: [
                  new FutureBuilder<List<History>>(
                    future: fetchHistory(),
                    builder: (context, snapshot) {
                      if (snapshot.hasData) {
                        List<History>? history = snapshot.data;
                        return new Wrap(
                            children: history!
                                .map((post) => new Wrap(
                                      children: <Widget>[
                                        Card(
                                          child: Row(
                                            crossAxisAlignment:
                                                CrossAxisAlignment.center,
                                            children: <Widget>[
                                              Image.network(
                                                post.thumb,
                                                height: 150,
                                                width: 100,
                                              ),
                                              Padding(
                                                padding:
                                                    const EdgeInsets.all(8.0),
                                                child: Column(
                                                  mainAxisSize:
                                                      MainAxisSize.min,
                                                  crossAxisAlignment:
                                                      CrossAxisAlignment.start,
                                                  children: <Widget>[
                                                    SizedBox(
                                                        width: MediaQuery.of(
                                                                    context)
                                                                .size
                                                                .width *
                                                            0.5,
                                                        child: Column(
                                                            children: <Widget>[
                                                              Text(
                                                                post.name,
                                                                maxLines: 3,
                                                                overflow:
                                                                    TextOverflow
                                                                        .ellipsis,
                                                                softWrap: false,
                                                                style: const TextStyle(
                                                                    color: Colors
                                                                        .black,
                                                                    fontWeight:
                                                                        FontWeight
                                                                            .bold,
                                                                    fontSize:
                                                                        10.0),
                                                              ),
                                                              const SizedBox(
                                                                  height: 20),
                                                              Wrap(
                                                                  children: <
                                                                      Widget>[
                                                                    const SizedBox(
                                                                        width:
                                                                            10),
                                                                    ElevatedButton(
                                                                      style: ElevatedButton
                                                                          .styleFrom(
                                                                        primary:
                                                                            const Color(0xFF03c3ec), // background
                                                                        onPrimary:
                                                                            Colors.white, // foreground
                                                                      ),
                                                                      onPressed:
                                                                          () {
                                                                        developer
                                                                            .log('In Click');
                                                                        Navigator.push(
                                                                            context,
                                                                            new MaterialPageRoute(builder: (context) => new Details(id: post.product_id.toString())));
                                                                      },
                                                                      child: const Text(
                                                                          'Info'),
                                                                    ),
                                                                    const SizedBox(
                                                                        width:
                                                                            10),
                                                                    const SizedBox(
                                                                        width:
                                                                            10),
                                                                    if (post.status ==
                                                                        3) ...[
                                                                      ElevatedButton(
                                                                        style: ElevatedButton
                                                                            .styleFrom(
                                                                          primary:
                                                                              const Color(0xFF03c3ec), // background
                                                                          onPrimary:
                                                                              Colors.white, // foreground
                                                                        ),
                                                                        onPressed:
                                                                            () {
                                                                          showModalBottomSheet<
                                                                              void>(
                                                                            context:
                                                                                context,
                                                                            builder:
                                                                                (BuildContext context) {
                                                                              return Container(
                                                                                height: 500,
                                                                                color: Colors.white,
                                                                                child: Center(
                                                                                  child: Column(
                                                                                    mainAxisAlignment: MainAxisAlignment.center,
                                                                                    mainAxisSize: MainAxisSize.min,
                                                                                    children: <Widget>[
                                                                                      Container(
                                                                                        padding: EdgeInsets.all(20),
                                                                                        child: Column(
                                                                                          children: [
                                                                                            Image(image: AssetImage('assets/images/shipping.jpg')),
                                                                                            SizedBox(height: 10),
                                                                                            Row(
                                                                                              children: [
                                                                                                const Opacity(opacity: .6, child: Text('NO RESI', style: TextStyle(fontSize: 15, fontWeight: FontWeight.bold))),
                                                                                                const Spacer(),
                                                                                                Opacity(opacity: .6, child: Text(post.no_resi, style: TextStyle(fontSize: 15, fontWeight: FontWeight.bold))),
                                                                                              ],
                                                                                            ),
                                                                                            const SizedBox(height: 10),
                                                                                            Row(
                                                                                              children: [
                                                                                                const Opacity(opacity: .6, child: Text('AIRPLANE', style: TextStyle(fontSize: 15, fontWeight: FontWeight.bold))),
                                                                                                const Spacer(),
                                                                                                Opacity(opacity: .6, child: Text(post.airplane, style: TextStyle(fontSize: 15, fontWeight: FontWeight.bold))),
                                                                                              ],
                                                                                            ),
                                                                                            const SizedBox(height: 10),
                                                                                            Row(
                                                                                              children: [
                                                                                                const Opacity(opacity: .6, child: Text('COURIER', style: TextStyle(fontSize: 15, fontWeight: FontWeight.bold))),
                                                                                                const Spacer(),
                                                                                                Opacity(opacity: .6, child: Text(post.courier, style: TextStyle(fontSize: 15, fontWeight: FontWeight.bold))),
                                                                                              ],
                                                                                            ),
                                                                                            const SizedBox(height: 30),
                                                                                            ElevatedButton(
                                                                                              child: const Text('Close'),
                                                                                              style: ElevatedButton.styleFrom(
                                                                                                minimumSize: const Size.fromHeight(50),
                                                                                                primary: Color(0xFF696cff), // background
                                                                                                onPrimary: Colors.white, // foreground
                                                                                              ),
                                                                                              onPressed: () => Navigator.pop(context),
                                                                                            ),
                                                                                          ],
                                                                                        ),
                                                                                      ),
                                                                                    ],
                                                                                  ),
                                                                                ),
                                                                              );
                                                                            },
                                                                          );
                                                                        },
                                                                        child: const Text(
                                                                            'Shipping'),
                                                                      ),
                                                                      ElevatedButton(
                                                                        style: ElevatedButton
                                                                            .styleFrom(
                                                                          primary:
                                                                              const Color(0xFF696cff), // background
                                                                          onPrimary:
                                                                              Colors.white, // foreground
                                                                        ),
                                                                        onPressed:
                                                                            () {},
                                                                        child: const Text(
                                                                            'Sold Out, highest Bid'),
                                                                      ),
                                                                    ] else if (post
                                                                            .status ==
                                                                        2) ...[
                                                                      // ElevatedButton(
                                                                      //   style: ElevatedButton
                                                                      //       .styleFrom(
                                                                      //     primary: const Color.fromARGB(
                                                                      //         255,
                                                                      //         236,
                                                                      //         7,
                                                                      //         64), // background
                                                                      //     onPrimary:
                                                                      //         Colors.white, // foreground
                                                                      //   ),
                                                                      //   onPressed:
                                                                      //       () {},
                                                                      //   child: const Text(
                                                                      //       'Cancel Bid'),
                                                                      // ),
                                                                      ElevatedButton(
                                                                        style: ElevatedButton
                                                                            .styleFrom(
                                                                          primary:
                                                                              const Color(0xFF696cff), // background
                                                                          onPrimary:
                                                                              Colors.white, // foreground
                                                                        ),
                                                                        onPressed:
                                                                            () {
                                                                          developer
                                                                              .log('In Click');
                                                                          Navigator.push(
                                                                              context,
                                                                              new MaterialPageRoute(builder: (context) => new Payment(id: post.id)));
                                                                        },
                                                                        child: const Text(
                                                                            'Pay'),
                                                                      )
                                                                    ] else if (post
                                                                            .status ==
                                                                        1) ...[
                                                                      ElevatedButton(
                                                                        style: ElevatedButton
                                                                            .styleFrom(
                                                                          primary:
                                                                              const Color(0xFF696cff), // background
                                                                          onPrimary:
                                                                              Colors.white, // foreground
                                                                        ),
                                                                        onPressed:
                                                                            () {},
                                                                        child: const Text(
                                                                            'Sold Out'),
                                                                      )
                                                                    ] else ...[
                                                                      ElevatedButton(
                                                                        style: ElevatedButton
                                                                            .styleFrom(
                                                                          primary: const Color.fromARGB(
                                                                              255,
                                                                              236,
                                                                              7,
                                                                              64), // background
                                                                          onPrimary:
                                                                              Colors.white, // foreground
                                                                        ),
                                                                        onPressed:
                                                                            () {
                                                                          cancelBid(
                                                                              post.id);
                                                                        },
                                                                        child: const Text(
                                                                            'Cancel Bid'),
                                                                      ),
                                                                    ],
                                                                  ])
                                                            ])),
                                                  ],
                                                ),
                                              ),
                                            ],
                                          ),
                                        )
                                      ],
                                    ))
                                .toList());
                      }

                      return new Center(
                        child: new Column(
                          children: <Widget>[
                            new Padding(padding: new EdgeInsets.all(50.0)),
                            const CircularProgressIndicator(),
                          ],
                        ),
                      );
                    },
                  ),
                ],
              ))
        ])
      ]),
      bottomNavigationBar: BottomBarLelangin(active: 1),
    );
  }
}
