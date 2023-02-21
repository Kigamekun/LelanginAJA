// ignore_for_file: prefer_const_literals_to_create_immutables, prefer_const_constructors, unnecessary_new

import 'package:flutter/material.dart';
import 'package:flutter_countdown_timer/current_remaining_time.dart';

import 'dart:async';
import 'dart:convert';
import 'package:getwidget/getwidget.dart';
import 'package:http/http.dart' as http;
import 'package:lelanginaja/ui/history.dart';
import 'package:flutter_html/flutter_html.dart';
import 'dart:developer' as developer;
import 'package:lelanginaja/ui/payment.dart';
import 'package:lelanginaja/model/Bidder.dart';
import 'package:lelanginaja/bloc/Bidder_bloc.dart';
import 'package:lelanginaja/widget/appbarlelangin.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:http/http.dart';
import 'package:flutter_countdown_timer/flutter_countdown_timer.dart';
import 'package:shared_preferences/shared_preferences.dart';

Future<Detail> fetchDetail(String id) async {
  SharedPreferences localStorage = await SharedPreferences.getInstance();
  var token = jsonDecode(localStorage.getString('token').toString());

  final response = await http.get(
    Uri.parse(dotenv.env['API_URL'].toString() + "/api/product?id=" + id),
    headers: {
      "Content-Type": "application/json",
      'Authorization': 'Bearer ' + token
    },
  );

  if (response.statusCode == 200) {
    // If the server did return a 200 OK response,
    // then parse the JSON.
    var responseJson = jsonDecode(response.body);
    developer.inspect(responseJson["data"]);
    return Detail.fromJson((responseJson as Map<String, dynamic>)["data"]);
  } else {
    developer.log(dotenv.env['API_URL'].toString() + "/api/product?id=" + id);
    developer.log(response.statusCode.toString());
    // If the server did not return a 200 OK response,
    // then throw an exception.
    throw Exception('Failed to load Detail');
  }
}

class Detail {
  final String id;
  final String name;
  final String description;
  final String start_from;
  final String end_auction;
  final int created_by;
  final String condition;
  final String saleroom_notice;
  final String catalogue_note;
  final String highest_bid;
  final int current_bid;
  final String auction_closed;

  final String status;
  final int is_bid;
  final String thumb;

  Detail(
      {required this.id,
      required this.name,
      required this.description,
      required this.start_from,
      required this.end_auction,
      required this.created_by,
      required this.condition,
      required this.saleroom_notice,
      required this.catalogue_note,
      required this.highest_bid,
      required this.current_bid,
      required this.auction_closed,
      required this.status,
      required this.is_bid,
      required this.thumb});

  factory Detail.fromJson(Map<String, dynamic> json) {
    developer.inspect(json);
    return Detail(
      id: json["id"].toString(),
      name: json["name"],
      description: json["description"],
      start_from: json["start_from"],
      end_auction: json["end_auction"],
      created_by: json["created_by"],
      condition: json["condition"],
      saleroom_notice: json["saleroom_notice"],
      catalogue_note: json["catalogue_note"],
      highest_bid: json["highest_bid"],
      current_bid: json["current_bid"],
      auction_closed: json["auction_closed"],
      status: json["status"],
      is_bid: json["is_bid"],
      thumb: json["thumb"],
    );
  }
}

class Details extends StatefulWidget {
  final String id;

  const Details({Key? key, required this.id}) : super(key: key);

  @override
  State<Details> createState() => _DetailsState();
}

class _DetailsState extends State<Details> {
  TextEditingController priceController = TextEditingController();

  TextEditingController noteController = TextEditingController();

  void bid(String price) async {
    SharedPreferences localStorage = await SharedPreferences.getInstance();
    var token = jsonDecode(localStorage.getString('token').toString());

    try {
      Response response = await post(
        Uri.parse(dotenv.env['API_URL'].toString() + "/api/bid/" + widget.id),
        body: {'auction_price': price},
        headers: {'Authorization': 'Bearer ' + token},
      );
      developer.log(response.statusCode.toString());

      if (response.statusCode == 200) {
        setState(() {});
        priceController.clear();
        showDialog(
            context: context,
            builder: (BuildContext context) {
              return AlertDialog(
                title: Text("Success"),
                content: Text('Bid already pushed'),
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
      } else {
        showDialog(
            context: context,
            builder: (BuildContext context) {
              return AlertDialog(
                title: Text("Error"),
                content: Text(jsonDecode(response.body)['message']),
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
    return MaterialApp(
        home: Scaffold(
      resizeToAvoidBottomInset: false,
      body: ListView(children: [
        Container(
          child: AppBarLelangin(),
        ),
        Container(
          child: FutureBuilder<Detail>(
            future: fetchDetail(widget.id),
            builder: (context, snapshot) {
              if (snapshot.hasData) {
                Detail? detail = snapshot.data;
                return Container(
                    child: Column(
                  children: [
                    SizedBox(
                      width: 400,
                      child: Card(
                        semanticContainer: true,
                        clipBehavior: Clip.antiAliasWithSaveLayer,
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(10.0),
                        ),
                        elevation: 5,
                        margin: const EdgeInsets.all(10),
                        child: Column(
                          children: [
                            Container(
                                alignment: Alignment.center,
                                padding: const EdgeInsets.all(20),
                                child: Text(detail!.name,
                                    style: const TextStyle(
                                      fontWeight: FontWeight.bold,
                                      fontSize: 20,
                                    ))),
                            Image.network(detail.thumb,
                                width: double.infinity, height: 400),
                            Container(
                                padding: const EdgeInsets.all(20),
                                child: Column(
                                  children: [
                                    Row(
                                      children: [
                                        const Text('Current Bid',
                                            style: TextStyle(fontSize: 12)),
                                        const Spacer(),
                                        Text(detail.current_bid.toString(),
                                            style: TextStyle(fontSize: 12)),
                                      ],
                                    ),
                                    const SizedBox(height: 10),
                                    Row(
                                      children: [
                                        const Text('Highest Bid',
                                            style: TextStyle(fontSize: 12)),
                                        const Spacer(),
                                        Text(detail.highest_bid,
                                            style: TextStyle(fontSize: 12)),
                                      ],
                                    ),
                                    const SizedBox(height: 10),
                                    Row(
                                      children: [
                                        const Text('Auction Closed',
                                            style: TextStyle(fontSize: 12)),
                                        const Spacer(),
                                        Text(detail.auction_closed,
                                            style: TextStyle(fontSize: 12)),
                                      ],
                                    ),
                                    const SizedBox(height: 10),
                                    Row(
                                      children: [
                                        const Text('Start From',
                                            style: TextStyle(fontSize: 12)),
                                        const Spacer(),
                                        Text(detail.start_from,
                                            style: TextStyle(fontSize: 12)),
                                      ],
                                    ),
                                    const SizedBox(height: 50),
                                    if (detail.is_bid >= 0) ...[
                                      Container(
                                          height: 200,
                                          child: SingleChildScrollView(
                                            child: Wrap(
                                              children: [
                                                new FutureBuilder<List<Bidder>>(
                                                    future:
                                                        fetchBidder(detail.id),
                                                    builder:
                                                        (context, snapshot) {
                                                      if (snapshot.hasData) {
                                                        List<Bidder>? bidder =
                                                            snapshot.data;
                                                        return Wrap(
                                                            children: bidder!
                                                                .map((post) =>
                                                                    new Wrap(
                                                                        children: <
                                                                            Widget>[
                                                                          if (post
                                                                              .is_win) ...[
                                                                            SizedBox(
                                                                              width: double.infinity,
                                                                              height: 100,
                                                                              child: Card(
                                                                                color: Color(0xFF696cff),
                                                                                elevation: 2,
                                                                                child: Padding(
                                                                                  padding: const EdgeInsets.all(8.0),
                                                                                  child: Row(
                                                                                    crossAxisAlignment: CrossAxisAlignment.center,
                                                                                    children: [
                                                                                      Column(
                                                                                        crossAxisAlignment: CrossAxisAlignment.start,
                                                                                        mainAxisAlignment: MainAxisAlignment.center,
                                                                                        children: [
                                                                                          Row(
                                                                                            children: [
                                                                                              Text(
                                                                                                post.name + " ",
                                                                                                style: const TextStyle(
                                                                                                  color: Colors.white,
                                                                                                  fontWeight: FontWeight.bold,
                                                                                                ),
                                                                                              ),
                                                                                              Text(
                                                                                                post.is_you == true ? '(You)' : '',
                                                                                                style: const TextStyle(
                                                                                                  color: Colors.white,
                                                                                                  fontWeight: FontWeight.bold,
                                                                                                ),
                                                                                              ),
                                                                                            ],
                                                                                          ),
                                                                                          Text(
                                                                                            post.auction_price.toString(),
                                                                                            style: const TextStyle(
                                                                                              color: Colors.white,
                                                                                              fontWeight: FontWeight.bold,
                                                                                            ),
                                                                                          )
                                                                                        ],
                                                                                      ),
                                                                                      Spacer(),
                                                                                      Image.asset(
                                                                                        'assets/images/medal.png',
                                                                                        height: 64,
                                                                                        width: 64,
                                                                                      ),
                                                                                    ],
                                                                                  ),
                                                                                ),
                                                                              ),
                                                                            ),
                                                                          ] else ...[
                                                                            SizedBox(
                                                                              width: double.infinity,
                                                                              height: 100,
                                                                              child: Card(
                                                                                elevation: 2,
                                                                                child: Padding(
                                                                                  padding: const EdgeInsets.all(8.0),
                                                                                  child: Row(
                                                                                    crossAxisAlignment: CrossAxisAlignment.center,
                                                                                    children: [
                                                                                      Column(
                                                                                        crossAxisAlignment: CrossAxisAlignment.start,
                                                                                        mainAxisAlignment: MainAxisAlignment.center,
                                                                                        children: [
                                                                                          Row(
                                                                                            children: [
                                                                                              Text(
                                                                                                post.name + " ",
                                                                                                style: const TextStyle(
                                                                                                  color: Colors.black,
                                                                                                  fontWeight: FontWeight.bold,
                                                                                                ),
                                                                                              ),
                                                                                              Text(
                                                                                                post.is_you == true ? '(You)' : '',
                                                                                                style: const TextStyle(
                                                                                                  color: Colors.black,
                                                                                                  fontWeight: FontWeight.bold,
                                                                                                ),
                                                                                              ),
                                                                                            ],
                                                                                          ),
                                                                                          Text(
                                                                                            post.auction_price,
                                                                                            textAlign: TextAlign.left,
                                                                                            style: const TextStyle(
                                                                                              color: Colors.black,
                                                                                              fontWeight: FontWeight.bold,
                                                                                            ),
                                                                                          ),
                                                                                        ],
                                                                                      ),
                                                                                    ],
                                                                                  ),
                                                                                ),
                                                                              ),
                                                                            ),
                                                                          ]
                                                                        ]))
                                                                .toList());
                                                      }
                                                      return new Center(
                                                        child: new Column(
                                                          children: <Widget>[
                                                            new Padding(
                                                                padding:
                                                                    new EdgeInsets
                                                                            .all(
                                                                        50.0)),
                                                            const CircularProgressIndicator(),
                                                          ],
                                                        ),
                                                      );
                                                    })
                                              ],
                                            ),
                                          ))
                                    ],
                                    const SizedBox(height: 30),
                                    CountdownTimer(
                                      endTime:
                                          DateTime.parse(detail.end_auction)
                                                  .millisecondsSinceEpoch +
                                              1000 * 30,
                                      widgetBuilder:
                                          (_, CurrentRemainingTime? time) {
                                        if (time == null) {
                                          return Text('EXPIRED');
                                        }
                                        return Text(
                                            '${time.days} d ${time.hours} h ${time.min} m ${time.sec} s');
                                      },
                                    ),
                                    const SizedBox(height: 30),
                                    Row(
                                      mainAxisAlignment:
                                          MainAxisAlignment.center,
                                      children: [
                                        // ElevatedButton(
                                        //   onPressed: () {},
                                        //   style: ElevatedButton.styleFrom(
                                        //     shape: RoundedRectangleBorder(
                                        //         side: const BorderSide(
                                        //             width: 1,
                                        //             color: Color(0xFF696cff)),
                                        //         borderRadius:
                                        //             BorderRadius.circular(5)),
                                        //     primary: Colors.white,
                                        //   ),
                                        //   child: const Text(
                                        //     'Save',
                                        //     style: TextStyle(
                                        //         fontSize: 15,
                                        //         color: Color(0xFF696cff)),
                                        //   ),
                                        // ),
                                        // const SizedBox(width: 20),
                                        if (detail.is_bid == 0) ...[
                                          ElevatedButton(
                                            style: ElevatedButton.styleFrom(
                                              primary: const Color(
                                                  0xFF696cff), // background
                                              onPrimary:
                                                  Colors.white, // foreground
                                            ),
                                            onPressed: () {
                                              showModalBottomSheet<void>(
                                                isScrollControlled: true,
                                                context: context,
                                                builder:
                                                    (BuildContext context) {
                                                  return SingleChildScrollView(
                                                    child: GestureDetector(
                                                      child: Padding(
                                                        padding: EdgeInsets.only(
                                                            bottom:
                                                                MediaQuery.of(
                                                                        context)
                                                                    .viewInsets
                                                                    .bottom),
                                                        child: Container(
                                                          height: 300,
                                                          color: Colors.white,
                                                          child: Center(
                                                            child: Column(
                                                              mainAxisAlignment:
                                                                  MainAxisAlignment
                                                                      .center,
                                                              mainAxisSize:
                                                                  MainAxisSize
                                                                      .min,
                                                              children: <
                                                                  Widget>[
                                                                Container(
                                                                  padding:
                                                                      const EdgeInsets
                                                                          .all(10),
                                                                  child:
                                                                      TextField(
                                                                    controller:
                                                                        priceController,
                                                                    decoration:
                                                                        const InputDecoration(
                                                                      border:
                                                                          OutlineInputBorder(),
                                                                      labelText:
                                                                          'Bid Price',
                                                                    ),
                                                                  ),
                                                                ),
                                                                Container(
                                                                  padding:
                                                                      EdgeInsets
                                                                          .all(
                                                                              10),
                                                                  child: Column(
                                                                    children: [
                                                                      ElevatedButton(
                                                                        style: ElevatedButton
                                                                            .styleFrom(
                                                                          minimumSize:
                                                                              const Size.fromHeight(50),
                                                                          primary:
                                                                              Color(0xFF696cff), // background
                                                                          onPrimary:
                                                                              Colors.white, // foreground
                                                                        ),
                                                                        onPressed:
                                                                            () {
                                                                          bid(priceController
                                                                              .text);
                                                                        },
                                                                        child: Text(
                                                                            'Bid'),
                                                                      ),
                                                                      SizedBox(
                                                                          height:
                                                                              10),
                                                                      ElevatedButton(
                                                                        child: const Text(
                                                                            'Close '),
                                                                        style: ElevatedButton
                                                                            .styleFrom(
                                                                          minimumSize:
                                                                              const Size.fromHeight(50),
                                                                          primary:
                                                                              Color(0xFF696cff), // background
                                                                          onPrimary:
                                                                              Colors.white, // foreground
                                                                        ),
                                                                        onPressed:
                                                                            () =>
                                                                                Navigator.pop(context),
                                                                      ),
                                                                    ],
                                                                  ),
                                                                ),
                                                              ],
                                                            ),
                                                          ),
                                                        ),
                                                      ),
                                                    ),
                                                  );
                                                },
                                              );
                                            },
                                            child: const Text('Bid'),
                                          ),
                                        ] else if (detail.is_bid == 1) ...[
                                          ElevatedButton(
                                              onPressed: () {},
                                              style: ElevatedButton.styleFrom(
                                                primary: Color.fromARGB(
                                                    255, 209, 105, 8),
                                              ),
                                              child: const Text(
                                                "You're Already bid",
                                                style: TextStyle(
                                                  fontSize: 15,
                                                  color: Colors.white,
                                                ),
                                              )),
                                          const SizedBox(width: 20),
                                          ElevatedButton(
                                            style: ElevatedButton.styleFrom(
                                              primary: const Color(
                                                  0xFF696cff), // background
                                              onPrimary:
                                                  Colors.white, // foreground
                                            ),
                                            onPressed: () {
                                              showModalBottomSheet<void>(
                                                isScrollControlled: true,
                                                context: context,
                                                builder:
                                                    (BuildContext context) {
                                                  return SingleChildScrollView(
                                                    child: GestureDetector(
                                                      child: Padding(
                                                        padding: EdgeInsets.only(
                                                            bottom:
                                                                MediaQuery.of(
                                                                        context)
                                                                    .viewInsets
                                                                    .bottom),
                                                        child: Container(
                                                          height: 300,
                                                          color: Colors.white,
                                                          child: Center(
                                                            child: Column(
                                                              mainAxisAlignment:
                                                                  MainAxisAlignment
                                                                      .center,
                                                              mainAxisSize:
                                                                  MainAxisSize
                                                                      .min,
                                                              children: <
                                                                  Widget>[
                                                                Container(
                                                                  padding:
                                                                      const EdgeInsets
                                                                          .all(10),
                                                                  child:
                                                                      TextField(
                                                                    controller:
                                                                        priceController,
                                                                    decoration:
                                                                        const InputDecoration(
                                                                      border:
                                                                          OutlineInputBorder(),
                                                                      labelText:
                                                                          'Bid Price',
                                                                    ),
                                                                  ),
                                                                ),
                                                                Container(
                                                                  padding:
                                                                      EdgeInsets
                                                                          .all(
                                                                              10),
                                                                  child: Column(
                                                                    children: [
                                                                      ElevatedButton(
                                                                        style: ElevatedButton
                                                                            .styleFrom(
                                                                          minimumSize:
                                                                              const Size.fromHeight(50),
                                                                          primary:
                                                                              Color(0xFF696cff), // background
                                                                          onPrimary:
                                                                              Colors.white, // foreground
                                                                        ),
                                                                        onPressed:
                                                                            () {
                                                                          bid(priceController
                                                                              .text);
                                                                        },
                                                                        child: Text(
                                                                            'Bid'),
                                                                      ),
                                                                      SizedBox(
                                                                          height:
                                                                              10),
                                                                      ElevatedButton(
                                                                        child: const Text(
                                                                            'Close '),
                                                                        style: ElevatedButton
                                                                            .styleFrom(
                                                                          minimumSize:
                                                                              const Size.fromHeight(50),
                                                                          primary:
                                                                              Color(0xFF696cff), // background
                                                                          onPrimary:
                                                                              Colors.white, // foreground
                                                                        ),
                                                                        onPressed:
                                                                            () =>
                                                                                Navigator.pop(context),
                                                                      ),
                                                                    ],
                                                                  ),
                                                                ),
                                                              ],
                                                            ),
                                                          ),
                                                        ),
                                                      ),
                                                    ),
                                                  );
                                                },
                                              );
                                            },
                                            child: const Text('Bid'),
                                          ),
                                        ] else ...[
                                          ElevatedButton(
                                              onPressed: () {},
                                              style: ElevatedButton.styleFrom(
                                                primary: Color.fromARGB(
                                                    255, 236, 72, 7),
                                              ),
                                              child: const Text(
                                                'Auction ended',
                                                style: TextStyle(
                                                  fontSize: 15,
                                                  color: Colors.white,
                                                ),
                                              ))
                                        ]
                                      ],
                                    )
                                  ],
                                ))
                          ],
                        ),
                      ),
                    ),
                    Container(
                      padding: const EdgeInsets.all(10),
                      child: Column(children: [
                        GFAccordion(
                            title: 'Description',
                            contentChild: Html(data: detail.description)),
                        GFAccordion(
                            title: 'Condition Report',
                            contentChild: Html(data: detail.condition)),
                        GFAccordion(
                            title: 'Salerooms Notice',
                            contentChild: Html(data: detail.saleroom_notice)),
                        GFAccordion(
                            title: 'Catalogue Note',
                            contentChild: Html(data: detail.catalogue_note)),
                        // WebView(
                        //   initialUrl: "https://belajarflutter.com/",
                        //   javascriptMode: JavascriptMode.unrestricted,
                        // ),
                      ]),
                    )
                  ],
                ));
              }
              return new Center(
                child: new Column(
                  children: <Widget>[
                    new Padding(padding: new EdgeInsets.all(50.0)),
                    new CircularProgressIndicator(),
                  ],
                ),
              );
            },
          ),
        ),
      ]),
    ));
  }
}
